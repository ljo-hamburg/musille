<?php 
/*show Polylang language switcher*/
if (function_exists("pll_the_languages")) {
	$pl_args = array(
				'show_flags'=>1,
				'show_names'=>1,
				'hide_if_empty'=>0,
				'display_names_as'	=> 'slug',
				'dropdown'	=> 1
			);

	?>

	<div class="polylang_crative_switcher mobile_switcher creative_header_icon">
		<?php pll_the_languages($pl_args); ?> 
	</div>

	<?php
}
?>