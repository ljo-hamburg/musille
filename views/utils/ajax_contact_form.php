<div class="lucille_contactform">
	<form class="lucille_contactform">						
		<ul class="contactform_fields">

			<li class="comment-form-author lucille_cf_entry">
				<input type="text" placeholder="<?php echo esc_html__('Name ', 'lucille'); ?>" name="contactName" id="contactName" class="lucille_cf_input required requiredField contactNameInput" />
				<div class="lucille_cf_error"><?php echo esc_html__('Please enter your name', 'lucille'); ?></div>
			</li>

			<li class="comment-form-email lucille_cf_entry">
				<input type="text" placeholder="<?php echo esc_html__('Email ', 'lucille'); ?>" name="email" id="contactemail" class="lucille_cf_input required requiredField email" />
				<div class="lucille_cf_error"><?php echo esc_html__('Please enter a correct email address', 'lucille'); ?></div>
			</li>

			<li class="comment-form-url lucille_cf_entry">
				<input type="text" placeholder="<?php echo esc_html__('Phone ', 'lucille'); ?>" name="phone" id="phone" class="lucille_cf_input" />
			</li>

			<li class="comment-form-comment lucille_cf_entry">
				<textarea name="comments" placeholder="<?php echo esc_html__('Message ', 'lucille'); ?>" id="commentsText" rows="10" cols="30" class="lucille_cf_input required requiredField contactMessageInput"></textarea>
				<div class="lucille_cf_error"><?php echo esc_html__('Please enter a message', 'lucille'); ?></div>
			</li>
			<?php
			/*
			//TODO: add recaptcha error here
			<li class="captcha_error">
				<span class="error"><?php echo esc_html__('Incorrect reCaptcha. Please enter reCaptcha challenge;', 'lucille'); ?></span>
			</li>
			*/
			?>
			<li class="wp_mail_error">
				<div class="lucille_cf_error"><?php echo esc_html__('Cannot send mail, an error occurred while delivering this message. Please try again later.', 'lucille'); ?></div>
			</li>	

			<li class="formResultOK">
				<div class="lucille_cf_error"><?php echo esc_html__('Your message was sent successfully. Thanks!', 'lucille'); ?></div>
			</li>
			<li class="notEmail">
				<div class="lucille_cf_error"><?php echo esc_html__('Your email address is not valid!', 'lucille'); ?></div>
			</li>
			<?php /*TODO: add recaptcha */?>
			<li>
				<input name="Button1" type="submit" id="submit" class="lc_button" value="<?php echo esc_html__('Send Email', 'lucille'); ?>" >
				<?php /*<div class="progressAction"><img src="<?php echo get_template_directory_uri()."/images/progress.gif"; ?>"></div> */ ?>
			</li>

		</ul>
		<input type="hidden" name="action" value="lucillecontactform_action" />
		<?php wp_nonce_field('lucillecontactform_action', 'contactform_nonce'); /*wp_nonce_field('lucillecontactform_action', 'contactform_nonce', true, false); */?>
	</form>
</div>