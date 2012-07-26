<?php

namespace Portal
{
  class SettingsController extends \WpMvc\BaseController
  {
    public function index()
    {
      global $current_site;
      global $site;
      global $theme_names;
      global $registration_options;

      $site = \WpMvc\Site::find( $current_site->id );

      $this->create_attribute_if_not_exists( $site, 'company_name' );
      $this->create_attribute_if_not_exists( $site, 'default_theme' );
      $this->create_attribute_if_not_exists( $site, 'portal_startpage' );
      $this->create_attribute_if_not_exists( $site, 'company_website' );
      $this->create_attribute_if_not_exists( $site, 'company_contact_name' );
      $this->create_attribute_if_not_exists( $site, 'company_contact_phone' );
      $this->create_attribute_if_not_exists( $site, 'company_contact_email' );
      $this->create_attribute_if_not_exists( $site, 'company_alias' );
      $this->create_attribute_if_not_exists( $site, 'activate_registration', 'a' );
      $this->create_attribute_if_not_exists( $site, 'welcome_text' );
      $this->create_attribute_if_not_exists( $site, 'user_agreement' );
      $this->create_attribute_if_not_exists( $site, 'pul_agreement' );
      $this->create_attribute_if_not_exists( $site, 'terms_version' );
      $this->create_attribute_if_not_exists( $site, 'company_logo' );

      $file_success = true;

      if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_GET['page'] ) && $_GET['page'] == 'portal_settings' ) {
        if ( $_FILES['site']['size']['sitemeta']['company_logo']['meta_value'] > 0 ) {
          $url = get_site_url();
          $root = $_SERVER['DOCUMENT_ROOT'];
          $dir = '/wp-content/uploads/portal/';
          $file = 'company_logo.jpg';
          $type = $_FILES['site']['type']['sitemeta']['company_logo']['meta_value'];

          if ( $type != 'image/png' && $type != 'image/x-png' ) {
            $html = \WpMvc\ViewHelper::admin_error( __( 'Wrong file format. Please use a PNG image. None of your settings were saved.' ) );

            echo $html;

            $file_success = false;
          } else {
            if ( ! is_dir( $root . $dir ) ) {
              mkdir( $root . $dir );
              chmod($root . $dir, 0755);
            }

            if ( file_exists( $root . $dir . $file ) )
              unlink( $root . $dir . $file );

            move_uploaded_file( $_FILES['site']['tmp_name']['sitemeta']['company_logo']['meta_value'], $root . $dir . $file );

            $resample_options = array(
              "path" => $root . $dir,
              "sample_filename" => $file,
              "new_filename" => "company_logo_128.png",
              "new_height" => 128,
              "save_image" => true
            );

            for( $resample_options["new_height"] = 128; $resample_options["new_height"] >= 16; $resample_options["new_height"] *= 0.5 ) {
              $resample_options["new_filename"] = "company_logo_" . $resample_options["new_height"] . ".png";
              \WpMvc\ImageHelper::resample_png( $resample_options );
            }

            $site->sitemeta->company_logo->meta_value = $url . $dir . "company_logo_64.png";
          }
        }

        $site->takes_post( $_POST['site'] );

        if ( $file_success ) {
          $site->save();

          static::redirect_to( "{$_SERVER['REQUEST_URI']}&portal_updated=1" );
        }
      }

      $this->get_theme_names( $theme_names );

      $registration_options = array(
        'a' => \Portal\SettingsHelper::activation_option_to_text( 'a' ),
        'b' => \Portal\SettingsHelper::activation_option_to_text( 'b' )#,
        #'c' => \Portal\SettingsHelper::activation_option_to_text( 'c' )
      );

      $this->render( $this, "index" );
    }

    private function create_attribute_if_not_exists( &$site, $attribute, $value = null )
    {
      if ( ! isset( $site->sitemeta->{$attribute} ) ) {
        $site->sitemeta->{$attribute} = \WpMvc\SiteMeta::virgin();
        $site->sitemeta->{$attribute}->site_id = $site->id;
        $site->sitemeta->{$attribute}->meta_key = "$attribute";
        $value ? $site->sitemeta->{$attribute}->meta_value = $value : $site->sitemeta->{$attribute}->meta_value = "";
        $site->sitemeta->{$attribute}->save();
      }
    }

    private function get_theme_names( &$theme_names )
    {
      $themes = wp_get_themes();

      $allowed_themes = \WpMvc\SiteMeta::find_by_meta_key( 'allowedthemes' );

      $allowed_themes_unserialized = unserialize( $allowed_themes[0]->meta_value );

      $theme_names = array();

      foreach ( $themes as $theme_key => $theme_value ) {
        if ( in_array( $theme_key, array_keys( $allowed_themes_unserialized ) ) )
          array_push( $theme_names, $theme_key );
      }
    }
  }
}
