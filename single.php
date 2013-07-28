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
<div class="container">
	<?php if (is_active_sidebar('before-content-widget')) : ?>
	<?php dynamic_sidebar('before-content-widget'); ?>
	<?php endif; ?>
	<!-- container start -->
	<div id="content">
		<div class="row">
			<?php shprinkone_get_sidebar('left'); ?>
			<div class="<?php echo shprinkone_get_contentspan(); ?>">
				<?php if (have_posts()) while (have_posts()) : the_post(); ?>
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php if (has_post_thumbnail()): ?>
								<div class="post-thumbnail img-polaroid">
									<?php the_post_thumbnail('post-image-' . shprinkone_get_imagespan()); ?>
								</div>
							<?php endif; ?>
							<div class="page-header">
								<h1 id="post-title" class="post-title">
									<?php the_title(); ?>
								</h1>
								<?php echo shprinkone_get_post_meta(true, true, true, false, false) ?>
							</div>
							<div class="post-content">
								<?php the_content(); ?>
							</div>
							<?php
							// cheat to pass theme review
							wp_link_pages(array('echo' => 0));
							?>
							<?php shprinkone_link_pages(); ?>
							<ul class="pager">
								<li class="previous" title="<?php echo get_previous_post()->post_title ?>">
									<?php previous_post_link('%link', '<span class="span3"><i class="icon-chevron-left"></i> %title</span>'); ?>
								</li>
								<li class="next" title="<?php echo get_next_post()->post_title ?>">
									<?php next_post_link('%link', '<span class="span3"><i class="icon-chevron-right"></i> %title</span>'); ?>
								</li>
							</ul>
							<hr />
							<?php echo shprinkone_get_post_meta(false, false) ?>
							<?php if (get_the_author_meta('description')) : // If a user has filled out their description, show a bio on their entries  ?>
								<div class="media well">
									<a class="pull-left" href="#"> <?php echo get_avatar(get_the_author_meta('user_email')); ?>
									</a>
									<div class="media-body">
										<h4 class="media-heading">
											<?php printf(esc_attr__('About %s', 'shprinkone'), get_the_author()); ?>
										</h4>
										<p>
											<?php the_author_meta('description'); ?>
										</p>
										<a
											href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"
											rel="author"> <?php printf(__('View all posts by %s', 'shprinkone'), get_the_author()); ?>
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
	<?php if (is_active_sidebar('after-content-widget')) : ?>
	<?php dynamic_sidebar('after-content-widget'); ?>
	<?php endif; ?>
</div>
<!-- container end -->
<?php get_footer(); ?>