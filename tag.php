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
<div id="content" class="container-fluid"><!-- container start -->
	<div class="row-fluid">
		<?php shprinkone_get_sidebar('left'); ?>
		<div class="<?php echo shprinkone_get_contentspan(); ?>">	
			<h1><?php echo __( 'Tag', 'shprinkone') . ': ' . single_tag_title( '', false ); ?></h1>
			<div id="post-container" class="masonry">
				<?php get_template_part('loop');	?>
			</div>
		</div>
		<?php shprinkone_get_sidebar('right'); ?>
	</div>
</div><!-- container end -->