<?php
/*
	Template Name: Blog
*/
?>

<?php get_header(); ?>

<?php
	/*get archive page settings here*/
	$blog_layout			= get_post_meta(get_the_ID(), 'lc_swp_meta_blog_layout', true);
	$container_class		= "";
	$single_item_template	= "views/archive/";

	switch ($blog_layout) {
		case "masonry":
			$container_class .= 'lc_content_full lc_blog_masonry_container blog_container';
			$single_item_template .= "post_item_masonry";
			$class_archive_nav = "lc_swp_full";
			break;
		case "grid":
			$container_class .= 'lc_content_full lc_blog_masonry_container grid_container blog_container';
			$single_item_template .= "post_item_grid";
			$class_archive_nav = "lc_swp_full";
			break;
		case "standard":
		default:
			$container_class .= 'lc_content_with_sidebar lc_basic_content_padding';
			$single_item_template .= "post_item_standard";
			$class_archive_nav = "lc_swp_full blog_standard_nav";
			break;
	}


	/*create the query*/
	if (get_query_var('paged')) {
		$paged = get_query_var('paged'); 
	} elseif (get_query_var('page')) { 
		$paged = get_query_var('page'); 
	} else {
		$paged = 1; 
	}

	$posts_per_page = get_option('posts_per_page');
	$offset = ($paged - 1) * $posts_per_page;

	$args = array(
		'numberposts'	=> -1,
		'posts_per_page'   => $posts_per_page,
		'paged'			   => $paged,
		'offset'           => $offset,
		'category'         => '',
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => array('post'),
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => false
	);

	$keep_old_wp_query = $wp_query;

	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);
	?>

	<?php
	set_query_var('lc_masonry_brick_class', 'lc_blog_masonry_brick');
	set_query_var('is_cpt_archive', false);

	if ($wp_query->have_posts()) {

		if ("standard" == $blog_layout) {
			/*add one more contianer*/
		?>
			<div class="lc_content_full lc_swp_boxed">
		<?php	
		}
		?>
		
		<div class="<?php echo esc_attr($container_class); ?>">
			<?php  if (("masonry" == $blog_layout) || ("grid" == $blog_layout)) { ?>
				<div class="blog-brick-size"></div>
			<?php } ?>

			<?php while ($wp_query->have_posts()) : the_post();
				get_template_part($single_item_template);
			endwhile; ?>

			<?php
			if ("standard" == $blog_layout) {
				set_query_var("class_archive_nav", $class_archive_nav);
				get_template_part('views/utils/archive_nav');
			}
			?>
		</div>
	<?php
		if ("standard" == $blog_layout) {
			get_sidebar();
			/*close parent container*/
		?>
			</div>
		<?php	
		} else {
			/*show nav in after the main container only for masonry/grid layout*/
			set_query_var("class_archive_nav", $class_archive_nav);
			get_template_part('views/utils/archive_nav');
		}

	} else  { ?>

		<div class="lc_swp_boxed lc_basic_content_padding">
			<p><?php esc_html__('Sorry, no posts matched your criteria.', 'lucille'); ?></p>
		</div>

	<?php 
	}

	$wp_query = null; $wp_query = $keep_old_wp_query;
?>


<?php get_footer(); ?>