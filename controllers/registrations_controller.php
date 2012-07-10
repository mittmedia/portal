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

      $this->render( $this, "signup_step_1" );
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

      $blog->options->public->option_value = 1;
      $blog->options->blog_public->option_value = 1;

      $blog->options->WPLANG->option_value = 'sv_SE';
      $blog->options->timezone_string->option_value = 'Europe/Stockholm';
      $blog->options->gmt_offset->option_value = 2;

      $blog->options->blogdescription->option_value = "En bloggare på {$current_site->domain}.";
      $blog->options->users_can_register->option_value = 0;
      $blog->options->ping_sites->option_value = '';
      $blog->options->enable_app->option_value = 1;
      $blog->options->enable_xmlrpc->option_value = 1;

      $blog->options->thumbnail_size_w->option_value = 128;
      $blog->options->thumbnail_size_h->option_value =128;
      $blog->options->thumbnail_crop->option_value = 1;
      $blog->options->medium_size_w->option_value = 512;
      $blog->options->medium_size_h->option_value = 512;
      $blog->options->large_size_w->option_value = 1024;
      $blog->options->large_size_h->option_value = 1024;
      $blog->options->embed_size_w->option_value = 512;
      $blog->options->embed_size_h->option_value = 512;

      $site = \WpMvc\Site::find( $current_site->id );

      $theme_stylesheet = $site->sitemeta->default_theme->meta_value;
      $theme_name = wp_get_theme( $site->sitemeta->default_theme->meta_value )->Name;

      $blog->options->current_theme->option_value = $theme_name;
      $blog->options->template->option_value = $theme_stylesheet;
      $blog->options->stylesheet->option_value = $theme_stylesheet;

      $blog->save();
    }

    private function send_confirmation_mail_to_user($blog_name, $password, $email)
    {
      global $current_site;

      $domain = $current_site->domain;

      $site = \WpMvc\Site::find($current_site->id);

      $admin_email = $site->sitemeta->admin_email->meta_value;

      $message = sprintf(
        __("Hej! Din blogg på %s har skapats. Du kan logga in på %s/%s/wp-admin med följande inloggningsuppgifter:\r\n\r\nAnvändarnamn: %s\r\nLösenord: %s\r\n\r\nOBS! Vi råder dig starkt att byta lösenord första gången du loggar in.\r\n\r\nLycka till med ditt bloggande! Om något skulle gå snett kan du kontakta %s."),
        $domain,
        'http://' . $domain,
        $blog_name,
        $blog_name,
        $password,
        $admin_email
      );

      wp_mail(
        $email,
        __(
          'Din blogg är redo!'
        ),
        $message
      );

      wp_mail(
        $admin_email ? $admin_email : 'dmu@mittmedia.se',
        sprintf(
          __(
            'En blogg har registrerats'
          ),
          $_POST['name']
        ),
        "En blogg har registrerats. Användaren fick det här meddelandet:\r\n\r\n" . $message
      );
    }
  }
}
