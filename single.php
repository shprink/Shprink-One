<?php
/**
 * Template file used to render a single post page.
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>
<?php get_header(); ?>
<div class="container"><!-- container start -->
	<div id="content">
		<div class="row">
			<?php shprinkone_get_sidebar('left'); ?>
			<div class="<?php echo shprinkone_get_contentspan(); ?>">	
				<?php if (have_posts()) while (have_posts()) : the_post(); ?>
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php if (has_post_thumbnail()): ?>
								<div class="post-thumbnail img-polaroid">
									<?php shprinkone_get_calendar(); ?>
									<?php the_post_thumbnail('post-image-' . shprinkone_get_imagespan()); ?>
								</div>
							<?php endif; ?>
							<h1 class="post-title"><?php the_title(); ?></h1>
							<?php echo shprinkone_get_post_meta(true) ?>
							<hr/>
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>

							<?php if (get_the_author_meta('description')) : // If a user has filled out their description, show a bio on their entries  ?>
								<div class="media well">
									<a class="pull-left" href="#">
										<?php echo get_avatar(get_the_author_meta('user_email')); ?>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php printf(esc_attr__('About %s', 'shprinkone'), get_the_author()); ?></h4>
										<p><?php the_author_meta('description'); ?></p>
										<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author">
											<?php printf(__('View all posts by %s', 'shprinkone'), get_the_author()); ?>
										</a>
									</div>
								</div>
							<?php endif; ?>
							<?php comments_template('', true); ?>
						</div>
					<?php endwhile; // end of the loop. ?>
			</div>
			<?php shprinkone_get_sidebar('right'); ?>
		</div>
	</div>
</div><!-- container end -->
<?php get_footer(); ?>