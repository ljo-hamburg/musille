<?php

$post_id = get_the_ID();
$post_type = get_post_type($post_id);
$taxonomy_name = "category";


if (!empty($post_id) && 
	is_single($post_id) && 
	LUCILLE_SWP_keep_single_post_meta()) {
	
	$post = $auth = get_post($post_id);
	$auth_id = $auth->post_author;

	if ('post' == $post_type) { ?>
		
			<div class="lc_post_meta">
				<span class="meta_entry swp_date_meta"><?php echo get_the_date('', $post_id); ?></span>
				<span class="meta_entry swp_author_meta">
					<?php echo esc_html__('by', 'lucille'); ?>
					<a href="<?php echo get_author_posts_url($auth_id); ?>">
						<?php echo get_the_author_meta('display_name', $auth_id); ?>
					</a>
				</span>
				<span class="meta_entry swp_cat_meta">
					<?php echo esc_html__('in&nbsp;', 'lucille'); the_category(' &#8901; '); ?>
				</span>
			</div>

	<?php }?>
<?php 
}
?>


