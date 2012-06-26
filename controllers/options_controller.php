<?php

namespace Portal
{
  class OptionsController extends \WpMvc\BaseController
  {
    public function index()
    {
      global $site;
      global $theme_names;

      $site = \WpMvc\Site::find( 1 );

      $this->create_attribute_if_not_exists( $site, 'companyname' );
      $this->create_attribute_if_not_exists( $site, 'defaulttheme' );
      $this->create_attribute_if_not_exists( $site, 'portalstartpage' );
      $this->create_attribute_if_not_exists( $site, 'companywebsite' );
      $this->create_attribute_if_not_exists( $site, 'companycontactname' );
      $this->create_attribute_if_not_exists( $site, 'companycontactphone' );
      $this->create_attribute_if_not_exists( $site, 'companycontactemail' );

      if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        $site->takes_post( $_POST['site'] );

        $site->save();

        static::redirect_to( "{$_SERVER['REQUEST_URI']}&portal_updated=1" );
      }

      $this->get_theme_names( $theme_names );

      $this->render( $this, "index" );
    }

    private function create_attribute_if_not_exists( &$site, $attribute )
    {
      if ( ! isset( $site->sitemeta->{$attribute} ) ) {
        $site->sitemeta->{$attribute} = SiteMeta::virgin();
        $site->sitemeta->{$attribute}->site_id = $site->id;
        $site->sitemeta->{$attribute}->meta_key = "$attribute";
        $site->sitemeta->{$attribute}->meta_value = "";
        $site->sitemeta->{$attribute}->save();
      }
    }

    private function get_theme_names( &$theme_names )
    {
      $themes = wp_get_themes();

      $theme_names = array();

      foreach ( $themes as $theme_key => $theme_value ) {
        array_push( $theme_names, $theme_key );
      }
    }
  }
}
