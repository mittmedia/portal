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

      $this->create_attribute_if_not_exists( $site, 'companyname' );
      $this->create_attribute_if_not_exists( $site, 'defaulttheme' );
      $this->create_attribute_if_not_exists( $site, 'portalstartpage' );
      $this->create_attribute_if_not_exists( $site, 'companywebsite' );
      $this->create_attribute_if_not_exists( $site, 'companycontactname' );
      $this->create_attribute_if_not_exists( $site, 'companycontactphone' );
      $this->create_attribute_if_not_exists( $site, 'companycontactemail' );
      $this->create_attribute_if_not_exists( $site, 'activate_registration', 'a' );
      $this->create_attribute_if_not_exists( $site, 'welcome_text' );

      if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        $site->takes_post( $_POST['site'] );

        $site->save();

        static::redirect_to( "{$_SERVER['REQUEST_URI']}&portal_updated=1" );
      }

      $this->get_theme_names( $theme_names );

      $registration_options = array(
        'a' => \Portal\SettingsHelper::activation_option_to_text( 'a' ),
        'b' => \Portal\SettingsHelper::activation_option_to_text( 'b' ),
        'c' => \Portal\SettingsHelper::activation_option_to_text( 'c' )
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
