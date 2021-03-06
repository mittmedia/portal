<?php
/*
Plugin Name: Portal
Plugin URI: https://github.com/mittmedia/portal
Description: It's a blog portal.
Version: 1.0.0
Author: Fredrik Sundström
Author URI: https://github.com/fredriksundstrom
License: MIT
*/

/*
Copyright (c) 2012 Fredrik Sundström

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
*/

require_once( 'wp_mvc/init.php' );

$portal_app = new \WpMvc\Application();

$portal_app->init( 'Portal', WP_PLUGIN_DIR . '/portal' );

load_plugin_textdomain('portal-settings', false, dirname(plugin_basename(__FILE__)) . '/languages/');

// WP: Add pages
add_action( 'network_admin_menu', 'portal_add_pages' );
function portal_add_pages()
{
  add_submenu_page( 'settings.php', 'Portal Settings', 'Portal', 'manage_network', 'portal_settings', 'portal_settings_page');
}

function portal_settings_page()
{
  global $portal_app;

  $portal_app->settings_controller->index();
}

add_action( 'init', 'portal_reset_registration' );
function portal_reset_registration() {
  global $current_site;

  $site = \WpMvc\Site::find( $current_site->id );

  $site->sitemeta->registration->meta_value = 'none';

  $site->save();
}

add_action( 'init', 'portal_reset_registration_on_blog' );
function portal_reset_registration_on_blog()
{
  global $current_blog;

  $blog = \WpMvc\Blog::find( $current_blog->blog_id );

  $blog->option->users_can_register = 0;

  $blog->save();
}

add_action( 'before_signup_form', 'portal_show_registration_form' );
function portal_show_registration_form()
{
  global $portal_app;

  $portal_app->registrations_controller->index();
}

add_filter( 'body_class', 'portal_put_alias_as_body_class' );
function portal_put_alias_as_body_class( $classes )
{
  global $current_site;

  $site = \WpMvc\Site::find( $current_site->id );

  if ( isset( $site->sitemeta->company_alias->meta_value ) )
    $classes[] = $site->sitemeta->company_alias->meta_value;

  return $classes;
}

if ( isset( $_GET['portal_updated'] ) ) {
  add_action( 'network_admin_notices', 'portal_updated_notice' );
}

function portal_updated_notice()
{
  $html = \WpMvc\ViewHelper::admin_notice( __( 'Settings saved.', 'portal-settings' ) );

  echo $html;
}

add_filter('admin_head', 'portal_registrations_add_scripts_and_styles');
function portal_registrations_add_scripts_and_styles() {
  if (isset( $_GET['page'] ) && $_GET['page'] == 'portal_settings') {
    echo '<link rel="stylesheet" type="text/css" href="' . WP_PLUGIN_URL . '/portal/assets/build/stylesheets/signup.css' . '" />';
  }
}
