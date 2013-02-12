<?php
/**
 * Template file used to render a Search Results Index page
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>
<?php get_header(); ?>
<div class="container">
	<!-- container start -->
	<div id="content">
		<div class="row">
			<?php shprinkone_get_sidebar('left'); ?>
			<div class="<?php echo shprinkone_get_contentspan(); ?>">
				<section>
					<header class="page-header">
						<h1 class="page-title">
							<?php printf(__('Search Results for: %s', 'sprinkone'), get_search_query()); ?>
						</h1>
					</header>
				</section>
				<?php get_template_part('loop'); ?>
			</div>
			<?php shprinkone_get_sidebar('right'); ?>
		</div>
	</div>
</div>
<!-- container end -->
<?php get_footer(); ?>