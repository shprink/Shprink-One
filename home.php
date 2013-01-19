<?php
/**
 * Template file used to render the Blog Posts Index, whether on the site front page or on a static page.
 * Note: on the Site Front Page, the Front Page template takes precedence over the Blog Posts Index (Home) template.
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>
<?php get_header(); ?>
<div id="content" class="container"><!-- container start -->
	<div class="row">
		<?php shprinkone_get_sidebar('left'); ?>
		<div class="<?php echo shprinkone_get_contentspan(); ?>">
			<div id="post-container" class="masonry">
				<?php get_template_part('loop_home'); ?>
			</div>
		</div>
		<?php shprinkone_get_sidebar('right'); ?>
	</div>
</div><!-- container end -->