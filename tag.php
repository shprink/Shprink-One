<?php
/**
 * Template file used to render a Tag Archive Index page
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>
<?php get_header(); ?>
<div class="container">
	<!-- container start -->
	<div class="row">
		<?php shprinkone_get_sidebar('left'); ?>
		<div id="content" class="<?php echo shprinkone_get_contentspan(); ?>">
			<div class="page-header">
				<h1 class="page-title">
					<?php echo __('Tag', 'shprinkone') . ': ' . single_tag_title('', false); ?>
				</h1>
			</div>
			<?php get_template_part('loop'); ?>
		</div>
		<?php shprinkone_get_sidebar('right'); ?>
	</div>
</div>
<!-- container end -->
<?php get_footer(); ?>
