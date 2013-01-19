<?php
/**
 * Template file used to render an Author Archive Index page 
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>
<?php get_header(); ?>
<div class="container"><!-- container start -->
	<div class="row">
		<?php shprinkone_get_sidebar('left'); ?>
		<div id="content" class="<?php echo shprinkone_get_contentspan(); ?>">
			<?php if (have_posts()) : ?>
				<?php the_post(); ?>
				<div class="media well vcard">
					<a class="photo pull-left" href="#">
						<?php echo get_avatar(get_the_author_meta('user_email')); ?>
					</a>
					<div class="media-body">
						<h2 class="media-heading fn"><?php printf(esc_attr__('Posts by %s', 'shprinkone'), get_the_author()); ?> <small class="nickname">(<?php the_author_meta('nickname'); ?>)</small></h2>
						<?php if (get_the_author_meta('description')): ?>
							<p class="note"><?php the_author_meta('description'); ?></p>
						<?php endif; ?>
						<ul>
							<?php if (get_the_author_meta('url')): ?>
								<li>
									<?php echo __('Website:', 'shprinkone') ?> <a class="url" href="<?php the_author_meta('url'); ?>"><?php the_author_meta('url'); ?></a>
								</li>
							<?php endif; ?>
								<?php if (get_the_author_meta('aim')): ?>
								<li>
									<?php echo __('AIM:', 'shprinkone') ?> <?php the_author_meta('aim'); ?>
								</li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
				<?php rewind_posts(); ?>
			<?php endif; ?>
			<?php get_template_part('loop'); ?>
		</div >
		<?php shprinkone_get_sidebar('right'); ?>
	</div>
</div><!-- container end -->