<?php global $site; ?>

<?php
  $content = array(
    'id' => 'text',
    'object' => array(
      'name' => $site->sitemeta->siteurl->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->siteurl,
      'default_value' => $site->sitemeta->siteurl->meta_value,
      'key' => 'meta_value'
    )
  );

  \WpMvc\FormHelper::render_form( $site, $content );
?>