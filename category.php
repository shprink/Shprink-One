<?php
/**
 * Template file used to render a Category Archive Index page
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
$category_description = category_description();
?>
<?php get_header(); ?>
<div class="container"><!-- container start -->
	<div class="row">
		<?php shprinkone_get_sidebar('left'); ?>
		<div id="content" class="<?php echo shprinkone_get_contentspan(); ?>">
			<h1><?php echo __('Category', 'shprinkone') . ': ' . single_cat_title('', false); ?></h1>
			<?php if (!empty($category_description)): ?>
				<p><?php echo $category_description; ?></p>
			<?php endif; ?>
			<?php get_template_part('loop'); ?>
		</div >
		<?php shprinkone_get_sidebar('right'); ?>
	</div>
</div><!-- container end -->