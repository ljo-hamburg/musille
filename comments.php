<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to LUCILLE_SWP_comment which is
 * located in the lucille/core/comments_template_cbk.php file.
 */
?>
<?php
	if ( !have_comments() && !comments_open(get_the_ID()) )
	{
		return;
	}
?>
<div id="comments">
	<?php if ( post_password_required() ) : ?>
			<p class="nopassword"><?php esc_html__('This post is password protected. Enter the password to view any comments.', 'lucille'); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>
<?php if ( have_comments() ) : ?>
			<h3 id="comments-title">
				<?php
				printf( _n( 'There is one comment on %2$s', 'There are %1$s comments on %2$s', get_comments_number(), 'lucille' ),
				number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
				?>
			</h3>

<?php if ( get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous">
					<?php 
					$allowed_tags = array(
						'span' => array(
							'class'	=> array()
						)
					);

					previous_comments_link(wp_kses(__('<span class="meta-nav">&larr;</span> Older Comments', 'lucille'), $allowed_tags));
					?>
				</div>

				<div class="nav-next">
					<?php 
					$allowed_tags = array(
						'span' => array(
							'class'	=> array()
						)
					);

					next_comments_link(wp_kses(__('Newer Comments <span class="meta-nav">&rarr;</span>', 'lucille'), $allowed_tags)); ?>
				</div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

			<ul class="commentlist">
				<?php
					/* Loop through and list the comments. Tell wp_list_comments()
					 * to use LUCILLE_SWP_comment() to format the comments.
					 * If you want to overload this in a child theme then you can
					 * define LUCILLE_SWP_comment() and that will be used instead.
					 * See LUCILLE_SWP_comment() in lucille/core/comments_template_cbk.php for more.
					 */
					wp_list_comments(
						array(
							'callback' => 'LUCILLE_SWP_comment'
						)
					);
				?>
			</ul>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous">
					<?php 
					$allowed_tags = array(
						'span' => array(
							'class'	=> array()
						)
					);
					
					previous_comments_link(wp_kses(__('<span class="meta-nav">&larr;</span> Older Comments', 'lucille'), $allowed_tags));
					?>
				</div>

				<div class="nav-next">
					<?php 
					$allowed_tags = array(
						'span' => array(
							'class'	=> array()
						)
					);
					next_comments_link(wp_kses(__( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'lucille' ), $allowed_tags)); 
					?>
				</div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

	<?php
	/* If there are no comments and comments are closed, let's leave a little note, shall we?
	 * But we only want the note on posts and pages that had comments in the first place.
	 */
	if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php esc_html__( 'Comments are closed.' , 'lucille' ); ?></p>
	<?php endif;  ?>

<?php endif; // end have_comments() ?>

<?php 
	$commentFormArgs = array(
		'title_reply'       => esc_html__('Leave a Reply', 'lucille'),
		'class_submit'		=> 'lc_button'
	);
	comment_form($commentFormArgs);
	
?>

</div>
<!-- #comments -->
