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
<?php if (have_posts()) : ?>
<div class="container-slideshow well well-small">
	<div class="container">
		<div class="row">
			<div class="span12">
				<?php get_template_part('loop_home'); ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<div class="container">
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
</div>
<!-- container end -->
<?php get_footer(); ?>