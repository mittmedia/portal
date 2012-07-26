<?php

namespace Portal
{
  class RegistrationsController extends \WpMvc\BaseController
  {
    public function index()
    {
      global $current_site;
      global $errors;
      global $domain;

      $site = \WpMvc\Site::find( $current_site->id );

      $domain = 'http://' . $site->domain;

      $errors = array();

      if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        $this->try_to_register();
      }

      if ($site->sitemeta->activate_registration->meta_value == 'b')
        $this->render( $this, "signup_step_1" );
      else
        $this->render( $this, "signup_deactivated" );
    }

    private function try_to_register()
    {
      global $errors;

      $blog_name  = filter_var(
        $_POST['registration']['blog_name'],
        FILTER_VALIDATE_REGEXP,
        array(
          "options" => array(
            "regexp" => "/^[a-zA-Z0-9]+$/"
          )
        )
      );
      $email      = filter_var( strtolower($_POST['registration']['email']), FILTER_VALIDATE_EMAIL );
      $password   = wp_generate_password();
      $biography  = filter_var( $_POST['registration']['biography'], FILTER_SANITIZE_STRING );
      $first_name = filter_var( $_POST['registration']['first_name'], FILTER_SANITIZE_STRING );
      $last_name  = filter_var( $_POST['registration']['last_name'], FILTER_SANITIZE_STRING );

      $blog_name = strtolower($blog_name);

      if ( ! $blog_name )
        $errors[] = "Blog Name Incorrect";

      if ( ! $email )
        $errors[] = "E-Mail Address Incorrect";

      if ( ! $biography )
        $errors[] = "Biography Incorrect";

      if ( ! $first_name )
        $errors[] = "First Name Incorrect";

      if ( ! $last_name )
        $errors[] = "Last Name Incorrect";

      if ( ! isset( $_POST['registration']['terms_and_conditions'] ) )
        $errors[] = 'Terms & Conditions Not Accepted';

      if ( \WpMvc\Blog::find_by_path("/$blog_name/") )
        $errors[] = "Blog Name Not Unique";

      if ( \WpMvc\User::find_by_email("$email") )
        $errors[] = "E-Mail Address Not Unique";

      if ( count( $errors ) == 0 ) {
        $user_id = $this->create_user( $blog_name, $password, $email );
        $blog_id = $this->create_blog( $blog_name, $user_id );
        $this->update_user_meta( $user_id, $blog_id, $first_name, $last_name, $biography );
        $this->update_blog_options( $blog_id );
        $this->send_confirmation_mail_to_user($blog_name, $password, $email);
      }
    }

    private function create_user( $blog_name, $password, $email )
    {
      return wpmu_create_user( $blog_name, $password, $email );
    }

    private function create_blog( $blog_name, $user_id )
    {
      global $current_site;

      $meta = array();

      $meta['public'] = 1;

      return wpmu_create_blog( $current_site->domain, '/' . $blog_name . '/', $blog_name, $user_id, $meta, $current_site->id );
    }

    private function update_user_meta( $user_id, $blog_id, $first_name, $last_name, $biography )
    {
      $user = \WpMvc\User::find( $user_id );

      $user->usermeta->first_name->meta_value = $first_name;
      $user->usermeta->last_name->meta_value = $last_name;
      $user->usermeta->description->meta_value = $biography;
      $user->usermeta->{"wp_{$blog_id}_capabilities"}->meta_value = 'a:1:{s:6:"editor";s:1:"1";}';
      $user->usermeta->{"wp_{$blog_id}_user_level"}->meta_value = 7;

      $user->save();
    }

    private function update_blog_options( $blog_id )
    {
      global $current_site;

      $blog = \WpMvc\Blog::find( $blog_id );

      $blog->option->public->option_value = 1;
      $blog->option->blog_public->option_value = 1;

      $blog->option->WPLANG->option_value = 'sv_SE';
      $blog->option->timezone_string->option_value = 'Europe/Stockholm';
      $blog->option->gmt_offset->option_value = 2;

      $blog->option->blogdescription->option_value = "En bloggare på {$current_site->domain}.";
      $blog->option->users_can_register->option_value = 0;
      $blog->option->ping_sites->option_value = '';
      $blog->option->enable_app->option_value = 1;
      $blog->option->enable_xmlrpc->option_value = 1;

      $blog->option->thumbnail_size_w->option_value = 128;
      $blog->option->thumbnail_size_h->option_value =128;
      $blog->option->thumbnail_crop->option_value = 1;
      $blog->option->medium_size_w->option_value = 512;
      $blog->option->medium_size_h->option_value = 512;
      $blog->option->large_size_w->option_value = 1024;
      $blog->option->large_size_h->option_value = 1024;
      $blog->option->embed_size_w->option_value = 512;
      $blog->option->embed_size_h->option_value = 512;

      $site = \WpMvc\Site::find( $current_site->id );

      $theme_stylesheet = $site->sitemeta->default_theme->meta_value;
      $theme_name = wp_get_theme( $site->sitemeta->default_theme->meta_value )->Name;

      $blog->option->current_theme->option_value = $theme_name;
      $blog->option->template->option_value = $theme_stylesheet;
      $blog->option->stylesheet->option_value = $theme_stylesheet;

      $blog->save();
    }

    private function send_confirmation_mail_to_user($blog_name, $password, $email)
    {
      global $current_site;

      $domain = $current_site->domain;

      $site = \WpMvc\Site::find($current_site->id);

      $admin_email = $site->sitemeta->admin_email->meta_value;

      $message = sprintf(
        __("Hi! Your blog over at %s was created. You may log in on %s/%s/wp-admin with the following credentials:\r\n\r\nUsername: %s\r\nPassword: %s\r\n\r\nPlease note! We strongly advice you to change the password upon your first login.\r\n\r\nGood luck with your blogging! In case anything were to break, please contact %s.", 'portal-settings'),
        $domain,
        'http://' . $domain,
        $blog_name,
        $blog_name,
        $password,
        $admin_email
      );

      wp_mail(
        $email,
        __('Your blog is ready!', 'portal-settings'),
        $message
      );

      wp_mail(
        $admin_email ? $admin_email : 'dmu@mittmedia.se',
        sprintf(
          __('A new blog was created'),
          $blog_name
        ),
        sprintf(
          __("A new blog was created. The user got this message from us:\r\n\r\n%s", 'portal-settings'),
          $message
        )
      );
    }
  }
}
