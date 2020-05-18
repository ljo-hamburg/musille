<?php get_header(); ?>

<div class="lc_content_full lc_swp_boxed lc_basic_content_padding">
	<div class="page_not_found">
		<div class="pnf_text">
			<h3>
				<?php echo esc_html__("The page you are looking for was not found", "lucille"); ?>
			</h3>
			<?php echo esc_html__("Sorry, the page you are looking for does not exist. Please return back to the site&#39;s homepage or contact us to report a problem.", "lucille"); ?>
		</div>
		<div class="lc_button">
			<a href="<?php echo get_home_url(); ?>">
				<?php echo  esc_html__("back to homepage", "lucille"); ?>
			</a>
		</div>
	</div>
</div>
<?php get_footer(); ?>