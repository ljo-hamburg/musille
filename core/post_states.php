<?php

add_filter('display_post_states', 'LUCILLE_SWP_custom_post_state', 10, 2);
function LUCILLE_SWP_custom_post_state($post_states, $post) {
	$page_template = get_post_meta($post->ID, '_wp_page_template', TRUE);

	switch($page_template) {
		case 'template-contact.php':
			$post_states[] = esc_html__('Contact Page', 'lucille');
			break;
		case 'template-blog.php':
			$post_states[] = esc_html__('Blog Page', 'lucille');
			break;
		default:
			break;
	}

	return $post_states;
}