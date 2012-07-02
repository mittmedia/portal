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
        $this->render( $this, "signup_step_1" );
      }
    }
  }
}
