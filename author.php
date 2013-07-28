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
<div class="container">
	<?php if (is_active_sidebar('before-content-widget')) : ?>
	<?php dynamic_sidebar('before-content-widget'); ?>
	<?php endif; ?>
	<!-- container start -->
	<div id="content">
		<div class="row">
			<?php shprinkone_get_sidebar('left'); ?>
			<div class="<?php echo shprinkone_get_contentspan(); ?>">
				<?php if (have_posts()) : ?>
				<?php the_post(); ?>
				<div class="media well vcard">
					<a class="photo pull-left" href="#"> <?php echo get_avatar(get_the_author_meta('user_email')); ?>
					</a>
					<div class="media-body">
						<h2 class="media-heading fn">
							<?php printf(esc_attr__('Posts by %s', 'shprinkone'), get_the_author()); ?>
							<small class="nickname">(<?php the_author_meta('nickname'); ?>)
							</small>
						</h2>
						<?php if (get_the_author_meta('description')): ?>
						<p class="note">
							<?php the_author_meta('description'); ?>
						</p>
						<?php endif; ?>
						<ul>
							<?php if (get_the_author_meta('url')): ?>
							<li><?php echo __('Website:', 'shprinkone') ?> <a class="url"
								href="<?php the_author_meta('url'); ?>"><?php the_author_meta('url'); ?>
							</a>
							</li>
							<?php endif; ?>
							<?php if (get_the_author_meta('aim')): ?>
							<li><?php echo __('AIM:', 'shprinkone') ?> <?php the_author_meta('aim'); ?>
							</li>
							<?php endif; ?>
							<?php if (get_the_author_meta('yim')): ?>
							<li><?php echo __('Yahoo IM:', 'shprinkone') ?> <?php the_author_meta('yim'); ?>
							</li>
							<?php endif; ?>
							<?php if (get_the_author_meta('jabber')): ?>
							<li><?php echo __('Jabber / Google Talk:', 'shprinkone') ?> <?php the_author_meta('jabber'); ?>
							</li>
							<?php endif; ?>
							<?php if (get_the_author_meta('googleplus')): ?>
							<li><?php echo __('Google+:', 'shprinkone') ?> <a
								href="<?php echo get_the_author_meta('googleplus') ?>"
								target="_blank"
								title="<?php echo sprintf(__('%s on Google+', 'shprinkone'), get_the_author()); ?>"><?php echo sprintf(__('%s on Google+', 'shprinkone'), get_the_author()); ?>
							</a>
							</li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
				<?php rewind_posts(); ?>
				<?php endif; ?>
				<?php get_template_part('loop'); ?>
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