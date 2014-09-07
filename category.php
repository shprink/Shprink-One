<?php
/**
 * Template file used to render a Category Archive Index page
 *
 * @subpackage  shprink_one
 * @since       1.0
 */
$option_slideshow = shprinkone_get_theme_option('theme_slideshow_category');
$category_description = category_description();
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
	<div id="content">
		<div class="row">
			<?php shprinkone_get_sidebar('left'); ?>
			<div class="<?php echo shprinkone_get_contentspan(); ?>">
				<div class="page-header">
					<h1 class="category-title">
						<?php echo __('Category', 'shprinkone') . ': ' . single_cat_title('', false); ?>
					</h1>
				</div>
				<?php if (!empty($category_description)): ?>
				<p>
					<?php echo $category_description; ?>
				</p>
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