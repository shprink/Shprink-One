<?php
/**
 * Template file used to render a static page (page post-type)
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
						<div id="page-<?php the_ID(); ?>" class="panel panel-default">
							<div class="panel-body">
								<?php if (has_post_thumbnail()): ?>
									<div class="post-thumbnail img-thumbnail">
										<?php the_post_thumbnail('post-image-' . shprinkone_get_imagespan(), array('class' => 'img-responsive')); ?>
									</div>
								<?php endif; ?>
								<div class="page-header">
									<h1 id="page-title" class="post-title">
										<?php the_title(); ?>
									</h1>
								</div>
								<?php the_content(); ?>
								<?php shprinkone_link_pages(); ?>
								<?php comments_template('', true); ?>
							</div>
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