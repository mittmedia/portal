<?php global $errors; global $domain ?>

<style>#content { display: none; } #content.show { display: block; }</style>

  <div class="container">
    <div class="twelve columns">
      <div class="mu_register">
        <form id="mm_signupform" method="post" action="/wp-signup.php" enctype="multipart/form-data">
          <?php do_action('signup_portal_extra_fields'); ?>
          <h3><?php _e( "Create your own blog in seconds!", 'portal-settings' ); ?></h3>
          <div class="description">
            <p><?php _e( "All you need to do is to fill in the form.", 'portal-settings' ); ?></p>
            <p><i><?php _e( "Please note that all fields are mandatory.", 'portal-settings' ); ?></i></p>
          </div>
          <?php if ( count( $errors ) > 0 ): ?>
            <div class="errors">
              <p class="error"><?php _e( "There are errors in the form. Please take a look in the form and correct it.", 'portal-settings' ); ?></p>
            </div>
          <?php endif; ?>

          <h5><?php _e( "Information about you (these are not public)", 'portal-settings' ); ?></h5>

          <label><?php _e( "First Name", 'portal-settings' ); ?></label>
          <?php if ( in_array( "First Name Incorrect", $errors ) ): ?>
            <p class="error"><?php _e( "Your first name didn't pass validation. Make sure it doesn't contain anything but letters. And also, spaces are not allowed.", 'portal-settings' ); ?></p>
          <?php endif; ?>
          <input type="text" name="registration[first_name]" value="<?php echo isset( $_POST['registration']['first_name'] ) ? $_POST['registration']['first_name'] : ''; ?>" style="background: <?php echo in_array( "First Name Incorrect", $errors ) ? "pink" : ""; ?>;" />

          <label><?php _e( "Last Name", 'portal-settings' ); ?></label>
          <?php if ( in_array( "Last Name Incorrect", $errors ) ): ?>
            <p class="error"><?php _e( "Your last name didn't pass validation. Make sure it doesn't contain anything but letters. And also, spaces are not allowed.", 'portal-settings' ); ?></p>
          <?php endif; ?>
          <input type="text" name="registration[last_name]" value="<?php echo isset( $_POST['registration']['last_name'] ) ? $_POST['registration']['last_name'] : ''; ?>" style="background: <?php echo in_array( "Last Name Incorrect", $errors ) ? "pink" : ""; ?>;" />

          <label><?php _e( "E-Mail Address", 'portal-settings' ); ?></label>
          <?php if ( in_array( "E-Mail Address Incorrect", $errors ) ): ?>
            <p class="error"><?php _e( "Your e-mail address didn't pass validation. Please make sure it's a valid e-mail address.", 'portal-settings' ); ?></p>
          <?php endif; ?>
          <?php if ( in_array( "E-Mail Address Not Unique", $errors ) ): ?>
            <p class="error"><?php _e( "The e-mail address you gave us is already registered with another blog.", 'portal-settings' ); ?></p>
          <?php endif; ?>
          <input type="text" name="registration[email]" value="<?php echo isset( $_POST['registration']['email'] ) ? $_POST['registration']['email'] : ''; ?>" style="background: <?php echo ( in_array( "E-Mail Address Incorrect", $errors ) || in_array( "E-Mail Address Not Unique", $errors ) ) ? "pink" : ""; ?>;" />
          <p class="instruction"><?php _e( "Please fill in an e-mail where we can reach you. We'll send a confirmation e-mail with a code to it, so it must be a real e-mail address you have access to.", 'portal-settings' ); ?></p>

          <h5><?php _e( "Information about the blog (these are public)", 'portal-settings' ); ?></h5>

          <label><?php _e( "Blog Name", 'portal-settings' ); ?></label>
          <?php if ( in_array( "Blog Name Incorrect", $errors ) ): ?>
            <p class="error"><?php _e( "Your blog name didn't pass validation. Make sure you only use letters and numbers. Spaces are not allowed.", 'portal-settings' ); ?></p>
          <?php endif; ?>
          <?php if ( in_array( "Blog Name Not Unique", $errors ) ): ?>
            <p class="error"><?php _e( "The blog name you wanted is already in use by another blog.", 'portal-settings' ); ?></p>
          <?php endif; ?>
          <input type="text" name="registration[blog_name]" value="<?php echo isset( $_POST['registration']['blog_name'] ) ? $_POST['registration']['blog_name'] : ''; ?>" style="background: <?php echo in_array( "Blog Name Incorrect", $errors ) ? "pink" : ""; ?>;" />
          <p class="instruction"><?php _e( "You can only use letters and numbers. Spaces are not allowed.", 'portal-settings' ); ?></p>

          <label><?php _e( "Tell us more! (Biography)", 'portal-settings' ); ?></label>
          <?php if (in_array('Biography Incorrect', $errors )): ?>
            <p class="error"><?php _e( "Your biography didn't pass validation. Maybe it's too short, or you used characters that our system can't handle.", 'portal-settings' ); ?></p>
          <?php endif; ?>
          <textarea type="text" name="registration[biography]" rows="5" cols="30" style="background: <?php echo in_array( "Biography Incorrect", $errors ) ? "pink" : ""; ?>;"><?php echo isset( $_POST['registration']['biography'] ) ? $_POST['registration']['biography'] : ''; ?></textarea>
          <p class="instruction"><?php _e( "You can tell us your life story or your life story in short. Please write a little bit about what subjects your blog will touch as well.", 'portal-settings' ); ?></p>

          <h5><?php _e( "Terms & Conditions", 'portal-settings' ); ?></h5>

          <div class="terms">
            <p><?php _e( "In order to blog with us you have to accept our terms and our conditions. Some of our more general terms are:", 'portal-settings' ); ?></p>
            <ul>
              <li class="instruction"><?php _e( "You are responsible for your own writings and the files (i.e. pictures) you publish. You are also responsible for comments that people write and you approve to be published.", 'portal-settings' ); ?></li>
              <li class="instruction"><?php _e( "You may not write or publish files that is prohibited by law.", 'portal-settings' ); ?></li>
              <li class="instruction"><?php _e( "You have full copyright on the content you publish.", 'portal-settings' ); ?></li>
              <li class="instruction"><?php _e( "Behave nicely.", 'portal-settings' ); ?></li>
              <li class="instruction"><?php _e( "If you break our rules, terms or conditions we have the right to cancel the account without notice.", 'portal-settings' ); ?></li>
            </ul>
            <p><a href="#"><?php _e( "Read our Terms & Conditions in full", 'portal-settings' ); ?></a></p>
            <p><a href="#"><?php _e( "Read about how we keep and use personal data.", 'portal-settings' ); ?></a></p>
            <?php if ( in_array( "Terms & Conditions Not Accepted", $errors ) ): ?>
              <p class="error"><?php _e( "You have to accept our Terms & Conditions to register and use this service.", 'portal-settings' ); ?></p>
            <?php endif; ?>

            <fieldset>

              <!-- Wrap each checkbox in a label, then give it the input and span for the text option -->
              <label for="registration_terms_and_conditions">
                <input type="checkbox" id="registration_terms_and_conditions" name="registration[terms_and_conditions]" <?php echo isset( $_POST['registration']['terms_and_conditions'] ) ? "checked='checked'" : ""; ?> style="background: <?php echo in_array( "Terms & Conditions Not Accepted", $errors ) ? "pink" : ""; ?>;" />
                <span><?php _e( "I accept the Terms & Conditions", 'portal-settings' ); ?></span>
              </label>

            </fieldset>
          </div>

          <div class="field submit">
            <input type="submit" value="<?php _e( "Register", 'portal-settings' ); ?>" />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>