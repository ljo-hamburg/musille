<?php 
/*show Polylang language switcher*/
if (function_exists("pll_the_languages")) {
	$pl_args = array(
				'show_flags'=>1,
				'show_names'=>0,
				'hide_if_empty'=>0,
				'hide_current'=>1
			);
	?>

	<ul class="polylang_crative_switcher creative_header_icon">
		<?php pll_the_languages($pl_args); ?> 
	</ul>

	<?php
}
?>