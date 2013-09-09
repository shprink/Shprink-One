<?php
/**
 * Template file used to render a Server 404 error page
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>
<?php get_header(); ?>
<div class="container-slideshow">
	<div class="container">
		<div class="row">
			<br/>
			<div id="content" class="col-md-12 col-lg-12">
				<div class="jumbotron">
					<h1>
						<?php echo __('404... Oups something went wrong...', 'shprinkone') ?>
					</h1>
					<p>
						<?php echo __('We are sorry but we cannot reach the page you are looking for... Perhaps you should try to:', 'shprinkone') ?>
					</p>

				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<!-- container start -->

	<div class="row">
		<div class="col-md-4 col-lg-4">
			<div class="well">
				<h4>
					<?php echo __('Search for it: ', 'shprinkone') ?>
				</h4>
				<?php get_search_form(); ?>
				<br /> <br />
			</div>
		</div>
		<div class="col-md-4 col-lg-4">
			<div class="well">
				<?php the_widget('WP_Widget_Recent_Posts', array('number' => 5), array('widget_id' => '404', 'before_title' => '<h4 class="widgettitle">' . __('Check Out The ', 'shprinkone'), 'after_title' => '</h4>')); ?>
			</div>
		</div>
		<div class="col-md-4 col-lg-4">
			<div class="well">
				<h4>
					<?php echo __('Check Out The Most Used Categories', 'shprinkone'); ?>
				</h4>
				<ul>
					<?php wp_list_categories(array('orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 5)); ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- container end -->
<?php get_footer(); ?>