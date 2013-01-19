<?php
/**
 * Template file used to include other template files 
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
			<?php get_template_part('loop'); ?>
		</div >
		<?php shprinkone_get_sidebar('right'); ?>
	</div>
</div><!-- container end -->