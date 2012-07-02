<?php global $site; global $theme_names; global $registration_options; ?>

<div class="wrap">
  <div id="icon-options-general" class="icon32"><br></div>
  <h2><?php _e( 'Portal Settings' ); ?></h2>
  <?php

  $content = array(
    array(
      'title' => 'Company Information',
      'type' => 'h3'
    ),
    array(
      'title' => 'Company Name',
      'name' => $site->sitemeta->companyname->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->companyname,
      'default_value' => $site->sitemeta->companyname->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Company Website',
      'name' => $site->sitemeta->companywebsite->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->companywebsite,
      'default_value' => $site->sitemeta->companywebsite->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Company Contact (Name)',
      'name' => $site->sitemeta->companycontactname->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->companycontactname,
      'default_value' => $site->sitemeta->companycontactname->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Company Contact (Phone)',
      'name' => $site->sitemeta->companycontactphone->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->companycontactphone,
      'default_value' => $site->sitemeta->companycontactphone->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Company Contact (E-mail)',
      'name' => $site->sitemeta->companycontactemail->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->companycontactemail,
      'default_value' => $site->sitemeta->companycontactemail->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Portal Settings',
      'type' => 'h3'
    ),
    array(
      'title' => 'Portal Start Page',
      'name' => $site->sitemeta->portalstartpage->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->portalstartpage,
      'default_value' => $site->sitemeta->portalstartpage->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Registration Settings',
      'type' => 'h3'
    ),
    array(
      'title' => 'Default Theme',
      'name' => $site->sitemeta->defaulttheme->meta_key,
      'type' => 'select',
      'options' => $theme_names,
      'object' => $site->sitemeta->defaulttheme,
      'default_value' => $site->sitemeta->defaulttheme->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Activate Registration',
      'name' => $site->sitemeta->activate_registration->meta_key,
      'type' => 'select',
      'options' => $registration_options,
      'object' => $site->sitemeta->activate_registration,
      'default_value' => \Portal\SettingsHelper::activation_option_to_text( $site->sitemeta->activate_registration->meta_value ),
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Welcome Text',
      'name' => $site->sitemeta->welcome_text->meta_key,
      'type' => 'textarea',
      'object' => $site->sitemeta->welcome_text,
      'default_value' => $site->sitemeta->welcome_text->meta_value,
      'key' => 'meta_value'
    )
  );

  \WpMvc\FormHelper::render_form( $site, $content );

  ?>
</div>
