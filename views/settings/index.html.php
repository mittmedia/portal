<?php global $site; global $theme_names; global $registration_options; ?>

<div class="wrap">
  <div id="icon-options-general" class="icon32"><br></div>
  <h2><?php _e( 'Portal Settings', 'portal-settings' ); ?></h2>
  <?php

  $logo_html = '';

  if ( trim( $site->sitemeta->company_logo->meta_value ) != '' ) {
    $logo_html = <<<html

<img src='{$site->sitemeta->company_logo->meta_value}' alt='' />

html;
  }

  $content = array(
    array(
      'title' => __('Company Information', 'portal-settings'),
      'type' => 'h3'
    ),
    array(
      'title' => __('Company Name', 'portal-settings'),
      'name' => $site->sitemeta->company_name->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->company_name,
      'default_value' => $site->sitemeta->company_name->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => __('Company Website', 'portal-settings'),
      'name' => $site->sitemeta->company_website->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->company_website,
      'default_value' => $site->sitemeta->company_website->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => __('Company Logo', 'portal-settings'),
      'name' => $site->sitemeta->company_logo->meta_key,
      'type' => 'file',
      'object' => $site->sitemeta->company_logo,
      'default_value' => $site->sitemeta->company_logo->meta_value,
      'key' => 'meta_value',
      'description' => "$logo_html"
    ),
    array(
      'title' => __('Adm. Contact (Name)', 'portal-settings'),
      'name' => $site->sitemeta->company_contact_name->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->company_contact_name,
      'default_value' => $site->sitemeta->company_contact_name->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => __('Adm. Contact (Phone)', 'portal-settings'),
      'name' => $site->sitemeta->company_contact_phone->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->company_contact_phone,
      'default_value' => $site->sitemeta->company_contact_phone->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => __('Adm. Contact (E-mail)', 'portal-settings'),
      'name' => $site->sitemeta->company_contact_email->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->company_contact_email,
      'default_value' => $site->sitemeta->company_contact_email->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => __('Company Alias (Websafe)', 'portal-settings'),
      'name' => $site->sitemeta->company_alias->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->company_alias,
      'default_value' => $site->sitemeta->company_alias->meta_value,
      'description' => __("It's used in the <body> of your themes and for advertisement.", 'portal-settings'),
      'key' => 'meta_value'
    ),
    array(
      'title' => __('Portal Settings', 'portal-settings'),
      'type' => 'h3'
    ),
    array(
      'title' => __('Portal Start Page', 'portal-settings'),
      'name' => $site->sitemeta->portal_startpage->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->portal_startpage,
      'default_value' => $site->sitemeta->portal_startpage->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => __('Registration Settings', 'portal-settings'),
      'type' => 'h3'
    ),
    array(
      'title' => __('Default Theme', 'portal-settings'),
      'name' => $site->sitemeta->default_theme->meta_key,
      'type' => 'select',
      'options' => $theme_names,
      'object' => $site->sitemeta->default_theme,
      'default_value' => $site->sitemeta->default_theme->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => __('Activate Registration', 'portal-settings'),
      'name' => $site->sitemeta->activate_registration->meta_key,
      'type' => 'select',
      'options' => $registration_options,
      'object' => $site->sitemeta->activate_registration,
      'default_value' => \Portal\SettingsHelper::activation_option_to_text( $site->sitemeta->activate_registration->meta_value ),
      'key' => 'meta_value'
    ),
    array(
      'title' => __('Welcome Text', 'portal-settings'),
      'name' => $site->sitemeta->welcome_text->meta_key,
      'type' => 'textarea',
      'object' => $site->sitemeta->welcome_text,
      'default_value' => $site->sitemeta->welcome_text->meta_value,
      'key' => 'meta_value'

    ),
    array(
      'title' => __('User Agreement', 'portal-settings'),
      'name' => $site->sitemeta->user_agreement->meta_key,
      'type' => 'editor_textarea',
      'object' => $site->sitemeta->user_agreement,
      'default_value' => $site->sitemeta->user_agreement->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => __('PUL Agreement', 'portal-settings'),
      'name' => $site->sitemeta->pul_agreement->meta_key,
      'type' => 'editor_textarea',
      'object' => $site->sitemeta->pul_agreement,
      'default_value' => $site->sitemeta->pul_agreement->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => __('Agreement Version', 'portal-settings'),
      'name' => $site->sitemeta->terms_version->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->terms_version,
      'default_value' => $site->sitemeta->terms_version->meta_value,
      'key' => 'meta_value'
    )
  );
  \WpMvc\FormHelper::render_form( $site, $content );
  ?>
</div>
