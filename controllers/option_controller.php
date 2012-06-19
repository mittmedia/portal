<?php

class OptionController extends \WpMvc\BaseController
{
  public function index()
  {
    global $site;

    $site = Site::find( 1 );

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
      $post_site = $_POST['site'];
      $post_site_meta = $_POST['site']['sitemeta'];

      $site->takes_post( $_POST['site'] );

      $site->save();

      $site->sitemeta->siteurl->save();
    }

    $this->render( $this, "index" );
  }
}