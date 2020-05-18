<?php
	$user_profiles = array();
	$user_profiles = LUCILLE_SWP_get_available_social_profiles();

	foreach ($user_profiles as $social_profile) {
		?>
		<div class="lc_social_profile">
			<a href="<?php echo esc_url($social_profile['url']); ?>" target="_blank">
				<i class="fa fa-<?php echo esc_attr($social_profile['icon']); ?>"></i>
			</a>
		</div>
		<?php
	}	
?>