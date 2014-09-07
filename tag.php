<?php
/**
 * Template file used to render a Tag Archive Index page
 *
 * @subpackage  shprink_one
 * @since       1.0
 */
$option_slideshow = shprinkone_get_theme_option('theme_slideshow_tag');
?>
<?php get_header(); ?>
<?php if (isset($option_slideshow['posts']) && $option_slideshow['posts'] > 0 && have_posts()) : ?>
    <?php get_template_part('loop_home'); ?>
<?php endif; ?>
<div class="container">
	<?php if (is_active_sidebar('before-content-widget')) : ?>
	<?php dynamic_sidebar('before-content-widget'); ?>
	<?php endif; ?>
	<!-- container start -->
	<div class="row">
		<?php shprinkone_get_sidebar('left'); ?>
		<div id="content" class="<?php echo shprinkone_get_contentspan(); ?>">
			<div class="page-header">
				<h1 class="tag-title">
					<?php echo __('Tag', 'shprinkone') . ': ' . single_tag_title('', false); ?>
				</h1>
			</div>
			<?php get_template_part('loop'); ?>
		</div>
		<?php shprinkone_get_sidebar('right'); ?>
	</div>
	<?php if (is_active_sidebar('after-content-widget')) : ?>
	<?php dynamic_sidebar('after-content-widget'); ?>
	<?php endif; ?>
</div>
<!-- container end -->
<?php get_footer(); ?>
