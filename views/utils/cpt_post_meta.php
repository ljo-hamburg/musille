<?php

$post_id = get_the_ID();
$post_type = get_post_type($post_id);
$taxonomy_name = "category";


if (!empty($post_id) && is_single($post_id)) {
	$post = $auth = get_post($post_id);
	$auth_id = $auth->post_author;

?>	
		<?php if ('post' != $post_type) { ?>
			<div class="lc_post_meta lc_cpt_category cpt_post_meta lc_swp_full">
				<span class="meta_entry lc_cpt_category">
					<?php 
					if (has_term('', $taxonomy_name, $post_id)) {
						the_terms($post_id, $taxonomy_name, '', ' ', '');	
					}
					?>
				</span>
			</div>
		<?php } ?>
<?php 
}