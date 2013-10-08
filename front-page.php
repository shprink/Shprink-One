<?php
/**
 * Template file used to render the Blog Posts Index, whether on the site front page or on a static page.
 * Note: on the Site Front Page, the Front Page template takes precedence over the Blog Posts Index (Home) template.
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
$options = shprinkone_get_theme_options();
$page_on_front = !(!get_option('page_on_front'));
?>
<?php if (!$page_on_front): ?>
	<?php get_header(); ?>
	<?php if (isset($options['theme_slideshow']['posts']) && $options['theme_slideshow']['posts'] > 0 && have_posts()) : ?>	
		<?php get_template_part('loop_home'); ?>
	<?php endif; ?>
	<div class="container">
		<?php if (is_active_sidebar('before-content-widget')) : ?>
			<?php dynamic_sidebar('before-content-widget'); ?>
		<?php endif; ?>
		<!-- container start -->
		<div id="content">
			<div class="row">
				<?php shprinkone_get_sidebar('left'); ?>
				<div class="<?php echo shprinkone_get_contentspan(); ?>">
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
<?php elseif (is_page()): ?>
	<?php get_template_part('page'); ?>
<?php endif; ?>