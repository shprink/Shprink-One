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
<div class="container"><!-- container start -->
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
							<h1 class="post-title"><?php the_title(); ?></h1>
							<hr/>
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>
							<?php comments_template('', true); ?>
						</div>
					<?php endwhile; // end of the loop. ?>
			</div>
			<?php shprinkone_get_sidebar('right'); ?>
		</div>
	</div>
</div><!-- container end -->
<?php get_footer(); ?>