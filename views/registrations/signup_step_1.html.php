<?php global $errors; global $domain ?>

<div id="content" class="widecolumn show">
  <div class="mu_register">
    <form id="mm_signupform" method="post" action="/wp-signup.php" enctype="multipart/form-data">
      <h1><?php _e( "We need to know who you are", 'portal-settings' ); ?></h1>
      <div class="description">
        <p><?php _e( "All you need to do is to fill in the form.", 'portal-settings' ); ?></p>
        <p><i><?php _e( "Note that all fields are mandatory.", 'portal-settings' ); ?></i></p>
      </div>
      <div class="form">
        <?php if ( count( $errors ) > 0 ): ?>
          <div class="errors">
            <p class="error"><?php _e( "There are errors in the form. Please take a look in the form and correct it.", 'portal-settings' ); ?></p>
          </div>
        <?php endif; ?>
        <fieldset>
          <legend><?php _e( "Information about you (these are not public)", 'portal-settings' ); ?></legend>
          <div class="field">
            <label><?php _e( "First Name", 'portal-settings' ); ?></label>
            <?php if ( in_array( "First Name Incorrect", $errors ) ): ?>
              <p class="error"><?php _e( "Your first name didn't pass validation. Make sure it doesn't contain anything but letters. And also, spaces are not allowed.", 'portal-settings' ); ?></p>
            <?php endif; ?>
            <input type="text" name="registration[first_name]" value="<?php echo isset( $_POST['registration']['first_name'] ) ? $_POST['registration']['first_name'] : ''; ?>" style="background: <?php echo in_array( "First Name Incorrect", $errors ) ? "pink" : ""; ?>;" />
          </div>
          <div class="field">
            <label><?php _e( "Last Name", 'portal-settings' ); ?></label>
            <?php if ( in_array( "Last Name Incorrect", $errors ) ): ?>
              <p class="error"><?php _e( "Your last name didn't pass validation. Make sure it doesn't contain anything but letters. And also, spaces are not allowed.", 'portal-settings' ); ?></p>
            <?php endif; ?>
            <input type="text" name="registration[last_name]" value="<?php echo isset( $_POST['registration']['last_name'] ) ? $_POST['registration']['last_name'] : ''; ?>" style="background: <?php echo in_array( "Last Name Incorrect", $errors ) ? "pink" : ""; ?>;" />
          </div>
          <!--<div class="field">
            <label><?php _e( "Street Address" ); ?></label>
            <?php if ( in_array( "Street Address Incorrect", $errors ) ): ?>
              <p class="error"><?php _e( "Your street address didn't pass validation. Make sure it doesn't contain anything but letters and numbers." ); ?></p>
            <?php endif; ?>
            <input type="text" name="registration[street_address]" value="<?php echo isset( $_POST['registration']['street_address'] ) ? $_POST['registration']['street_address'] : ''; ?>" style="background: <?php echo in_array( "Street Address Incorrect", $errors ) ? "pink" : ""; ?>;" />
          </div>
          <div class="field">
            <label><?php _e( "Postal Code" ); ?></label>
            <?php if ( in_array( "Postal Code Incorrect", $errors ) ): ?>
              <p class="error"><?php _e( "Your postal code didn't pass validation. Make sure it doesn't contain anything but numbers." ); ?></p>
            <?php endif; ?>
            <input type="text" name="registration[postal_code]" value="<?php echo isset( $_POST['registration']['postal_code'] ) ? $_POST['registration']['postal_code'] : ''; ?>" style="background: <?php echo in_array( "Postal Code Incorrect", $errors ) ? "pink" : ""; ?>;" />
          </div>
          <div class="field">
            <label><?php _e( "City" ); ?></label>
            <?php if ( in_array( "City Incorrect", $errors ) ): ?>
              <p class="error"><?php _e( "Your city didn't pass validation. Make sure it doesn't contain anything but letters." ); ?></p>
            <?php endif; ?>
            <input type="text" name="registration[city]" value="<?php echo isset( $_POST['registration']['city'] ) ? $_POST['registration']['city'] : ''; ?>" style="background: <?php echo in_array( "City Incorrect", $errors ) ? "pink" : ""; ?>;" />
          </div>
          <div class="field">
            <label><?php _e( "Mobile Phone Number" ); ?></label>
            <?php if ( in_array( "Mobile Phone Number Incorrect", $errors ) ): ?>
              <p class="error"><?php _e( "Your mobile phone number didn't pass validation. Make sure it doesn't contain anything but numbers." ); ?></p>
            <?php endif; ?>
            <p class="instruction"><?php _e( "Please fill in a mobile phone number where we can reach you." ); ?></p>
            <input type="text" name="registration[phone]" value="<?php echo isset( $_POST['registration']['phone'] ) ? $_POST['registration']['phone'] : ''; ?>" style="background: <?php echo in_array( "Mobile Phone Number Incorrect", $errors ) ? "pink" : ""; ?>;" />
          </div>-->
          <div class="field">
            <label><?php _e( "E-Mail Address", 'portal-settings' ); ?></label>
            <?php if ( in_array( "E-Mail Address Incorrect", $errors ) ): ?>
              <p class="error"><?php _e( "Your e-mail address didn't pass validation. Please make sure it's a valid e-mail address.", 'portal-settings' ); ?></p>
            <?php endif; ?>
            <?php if ( in_array( "E-Mail Address Not Unique", $errors ) ): ?>
              <p class="error"><?php _e( "The e-mail address you gave us is already registered with another blog.", 'portal-settings' ); ?></p>
            <?php endif; ?>
            <p class="instruction"><?php _e( "Please fill in an e-mail where we can reach you. We'll send a confirmation e-mail with a code to it, so it must be a real e-mail address you have access to.", 'portal-settings' ); ?></p>
            <input type="text" name="registration[email]" value="<?php echo isset( $_POST['registration']['email'] ) ? $_POST['registration']['email'] : ''; ?>" style="background: <?php echo ( in_array( "E-Mail Address Incorrect", $errors ) || in_array( "E-Mail Address Not Unique", $errors ) ) ? "pink" : ""; ?>;" />
          </div>
        </fieldset>
        <fieldset>
          <legend><?php _e( "Information about the blog (these are public)", 'portal-settings' ); ?></legend>
          <div class="field">
            <label><?php _e( "Blog Name", 'portal-settings' ); ?></label>
            <?php if ( in_array( "Blog Name Incorrect", $errors ) ): ?>
              <p class="error"><?php _e( "Your blog name didn't pass validation. Make sure you only use letters and numbers. Spaces are not allowed.", 'portal-settings' ); ?></p>
            <?php endif; ?>
            <?php if ( in_array( "Blog Name Not Unique", $errors ) ): ?>
              <p class="error"><?php _e( "The blog name you wanted is already in use by another blog.", 'portal-settings' ); ?></p>
            <?php endif; ?>
            <p class="instruction"><?php _e( "You can only use letters and numbers. Spaces are not allowed.", 'portal-settings' ); ?></p>
            <input type="text" name="registration[blog_name]" value="<?php echo isset( $_POST['registration']['blog_name'] ) ? $_POST['registration']['blog_name'] : ''; ?>" style="background: <?php echo in_array( "Blog Name Incorrect", $errors ) ? "pink" : ""; ?>;" />
          </div>
          <div class="field">
            <label><?php _e( "Tell us more! (Biography)", 'portal-settings' ); ?></label>
            <?php if (in_array('Biography Incorrect', $errors )): ?>
              <p class="error"><?php _e( "Your biography didn't pass validation. Maybe it's too short, or you used characters that our system can't handle.", 'portal-settings' ); ?></p>
            <?php endif; ?>
            <p class="instruction"><?php _e( "You can tell us your life story or your life story in short. Please write a little bit about what subjects your blog will touch as well.", 'portal-settings' ); ?></p>
            <textarea type="text" name="registration[biography]" rows="5" cols="30" style="background: <?php echo in_array( "Biography Incorrect", $errors ) ? "pink" : ""; ?>;"><?php echo isset( $_POST['registration']['biography'] ) ? $_POST['registration']['biography'] : ''; ?></textarea>
          </div>
        </fieldset>
        <fieldset>
          <legend><?php _e( "Terms & Conditions", 'portal-settings' ); ?></legend>
          <div class="field">
            <p class="instruction"><?php _e( "In order to blog with us you have to accept our terms and our conditions. Some of our more general terms are:", 'portal-settings' ); ?></p>
            <ul>
              <li class="instruction"><?php _e( "You are responsible for your own writings and the files (i.e. pictures) you publish. You are also responsible for comments that people write and you approve to be published.", 'portal-settings' ); ?></li>
              <li class="instruction"><?php _e( "You may not write or publish files that is prohibited by law.", 'portal-settings' ); ?></li>
              <li class="instruction"><?php _e( "You have full copyright on the content you publish.", 'portal-settings' ); ?></li>
              <li class="instruction"><?php _e( "Behave nicely.", 'portal-settings' ); ?></li>
              <li class="instruction"><?php _e( "If you break our rules, terms or conditions we have the right to cancel the account without notice.", 'portal-settings' ); ?></li>
            </ul>
            <p class="instruction"><?php _e( "Read our Terms & Conditions in full", 'portal-settings' ); ?></p>
            <p class="instruction"><?php _e( "Read about how we keep and use personal data.", 'portal-settings' ); ?></p>
            <?php if ( in_array( "Terms & Conditions Not Accepted", $errors ) ): ?>
              <p class="error"><?php _e( "You have to accept our Terms & Conditions to register and use this service.", 'portal-settings' ); ?></p>
            <?php endif; ?>
            <input type="checkbox" id="registration_terms_and_conditions" name="registration[terms_and_conditions]" <?php echo isset( $_POST['registration']['terms_and_conditions'] ) ? "checked='checked'" : ""; ?> style="background: <?php echo in_array( "Terms & Conditions Not Accepted", $errors ) ? "pink" : ""; ?>;" />
            <label for="registration_terms_and_conditions"><?php _e( "I accept the Terms & Conditions", 'portal-settings' ); ?></label>
          </div>
        </fieldset>
        <div class="field submit">
          <input type="submit" value="<?php _e( "Register", 'portal-settings' ); ?>" />
        </div>
      </div>
    </form>
  </div>
</div>
