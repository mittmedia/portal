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
      'name' => $site->sitemeta->company_name->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->company_name,
      'default_value' => $site->sitemeta->company_name->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Company Website',
      'name' => $site->sitemeta->company_website->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->company_website,
      'default_value' => $site->sitemeta->company_website->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Adm. Contact (Name)',
      'name' => $site->sitemeta->company_contact_name->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->company_contact_name,
      'default_value' => $site->sitemeta->company_contact_name->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Adm. Contact (Phone)',
      'name' => $site->sitemeta->company_contact_phone->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->company_contact_phone,
      'default_value' => $site->sitemeta->company_contact_phone->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Adm. Contact (E-mail)',
      'name' => $site->sitemeta->company_contact_email->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->company_contact_email,
      'default_value' => $site->sitemeta->company_contact_email->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Company Alias (Websafe)',
      'name' => $site->sitemeta->company_alias->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->company_alias,
      'default_value' => $site->sitemeta->company_alias->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Portal Settings',
      'type' => 'h3'
    ),
    array(
      'title' => 'Portal Start Page',
      'name' => $site->sitemeta->portal_startpage->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->portal_startpage,
      'default_value' => $site->sitemeta->portal_startpage->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'Registration Settings',
      'type' => 'h3'
    ),
    array(
      'title' => 'Default Theme',
      'name' => $site->sitemeta->default_theme->meta_key,
      'type' => 'select',
      'options' => $theme_names,
      'object' => $site->sitemeta->default_theme,
      'default_value' => $site->sitemeta->default_theme->meta_value,
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

    ),
    array(
      'title' => 'User Agreement',
      'name' => $site->sitemeta->user_agreement->meta_key,
      'type' => 'editor_textarea',
      'object' => $site->sitemeta->user_agreement,
      'default_value' => $site->sitemeta->user_agreement->meta_value,
      'key' => 'meta_value'
    ),
    array(
      'title' => 'PUL Agreement',
      'name' => $site->sitemeta->pul_agreement->meta_key,
      'type' => 'editor_textarea',
      'object' => $site->sitemeta->pul_agreement,
      'default_value' => $site->sitemeta->pul_agreement->meta_value,
      'key' => 'meta_value'
    )
  );
  \WpMvc\FormHelper::render_form( $site, $content );
  ?>
</div>
