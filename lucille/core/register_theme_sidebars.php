<?php

function LUCILLE_SWP_widgets_init() 
{
	if (function_exists('register_sidebar')) {
		register_sidebar(
			array(
				'name' => esc_html__('Main Sidebar', 'lucille'),
				'id' => 'main-sidebar',
				'description' => esc_html__('Right Sidebar', 'lucille'),
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>',
			)
		);

		/*footer sidebars*/
		register_sidebar(
			array(
				'name' => esc_html__('Footer', 'lucille'),
				'id' => 'footer-sidebar',
				'description' => esc_html__('Appears in the footer area', 'lucille'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="footer-widget-title">',
				'after_title' => '</h3>',
			)
		);
	}
}
add_action('widgets_init','LUCILLE_SWP_widgets_init');



?>