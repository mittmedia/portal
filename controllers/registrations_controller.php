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

      if ( isset( $_GET['step'] ) ) {
        switch ( $_GET['step'] ) {
          case '2':
            $this->render( $this, "signup_step_2" );
            break;
          case '3':
            $this->render( $this, "signup_step_3" );
            break;
        }
      } else {
        $this->try_to_register();

        $this->render( $this, "signup_step_1" );
      }
    }

    private function try_to_register()
    {
      $blog_name    = strtolower( $_POST['registration']['blog_name'] );
      $email        = strtolower( $_POST['registration']['email'] );
      $password     = wp_generate_password();
      $user_id      = $this->create_user( $blog_name, $password, $email );
      $blog_id      = $this->create_blog( $blog_name, $user_id );
      $biography    = $_POST['registration']['biography'];
      $first_name   = $_POST['registration']['first_name'];
      $last_name    = $_POST['registration']['last_name'];
      $created      = time();
      $created_by   = $user_id;
    }

    private function create_user( $blog_name, $password, $email )
    {
      return wpmu_create_user( $blog_name, $password, $email );
    }

    private function create_blog( $blog_name, $user_id )
    {
      global $current_site;

      return wpmu_create_blog( $current_site->domain, '/' . $blog_name . '/', $blog_name, $user_id );
    }

    private function make_blog_public( $blog_id )
    {

    }

    private function update_user_meta( $first_name, $last_name )
    {

    }
  }
}
