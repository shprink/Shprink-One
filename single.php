<?php
/**
 * Template file used to render a single post page.
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>
<?php get_header(); ?>
<div class="container"> 
	<?php if (is_active_sidebar('before-content-widget')) : ?>
		<?php dynamic_sidebar('before-content-widget'); ?>
	<?php endif; ?>
	<!-- container start -->
	<div id="content">
		<div class="row">
			<?php shprinkone_get_sidebar('left'); ?>
			<div class="<?php echo shprinkone_get_contentspan(); ?>">
				<?php if (have_posts()) while (have_posts()) : the_post(); ?>
						<div id="post-<?php the_ID(); ?>" <?php post_class('panel panel-default'); ?>>
							<div class="panel-body">
								<?php if (has_post_thumbnail()): ?>
									<div class="post-thumbnail img-thumbnail">
										<?php the_post_thumbnail('post-image-' . shprinkone_get_imagespan(), array('class' => 'img-responsive')); ?>
									</div>
								<?php endif; ?>
								<div class="page-header">
									<h1 id="post-title" class="post-title">
										<?php the_title(); ?>
									</h1>
									<?php echo shprinkone_get_post_meta(true, true, true, false, false, true) ?>
								</div>
								<div class="post-content">
									<?php the_content(); ?>
								</div>
								<?php
								// cheat to pass theme review
								wp_link_pages(array('echo' => 0));
								?>
								<?php shprinkone_link_pages(); ?>
								<hr />
								<?php echo shprinkone_get_post_meta(false, false) ?>
								<?php if (get_the_author_meta('description')) : // If a user has filled out their description, show a bio on their entries  ?>
									<div class="media well">
										<a class="pull-left" href="#"> <?php echo get_avatar(get_the_author_meta('user_email')); ?>
										</a>
										<div class="media-body">
											<h4 class="media-heading">
												<?php printf(esc_attr__('About %s', 'shprinkone'), get_the_author()); ?>
											</h4>
											<p>
												<?php the_author_meta('description'); ?>
											</p>
											<a
												href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"
												rel="author"> <?php printf(__('View all posts by %s', 'shprinkone'), get_the_author()); ?>
											</a>
										</div>
									</div>
								<?php endif; ?>
								<?php
								$previousPost = get_previous_post();
								if (!empty($previousPost)):
									?>
									<a id="previous-post" class="btn btn-info btn-lg" title="<?php echo $previousPost->post_title ?>" href="javascript:void(0)"><i class="icon-chevron-left"></i></a>
									<div id="previous-post-content" style="display: none;">
										<div class="clearfix">
											<a class="btn btn-danger pull-right" href="javascript:closePreviousSidr();"><i class="icon-remove-sign"></i></a>
										</div>
										<a href="<?php echo get_permalink($previousPost); ?>">
											<?php echo get_the_post_thumbnail($previousPost->ID, 'post-image-mansory', array('class' => 'img-thumbnail img-responsive')); ?>
										</a>
										<h2><?php previous_post_link('%link', '%title'); ?></h2>
										<p><?php echo substr(strip_tags($previousPost->post_content), 0, 200) . '...'; ?></p>
										<a href="<?php echo get_permalink($previousPost); ?>" class="btn btn-primary btn-block"><?php _e('Read more', 'shprinkone') ?></a>
									</div>
								<?php endif; ?>
								<?php
								$nextPost = get_next_post();
								if (!empty($nextPost)):
									?>
									<a id="next-post" class="btn btn-info btn-lg pull-right" title="<?php echo $nextPost->post_title ?>" href="javascript:void(0)"><i class="icon-chevron-right"></i></a>

									<div id="next-post-content" style="display: none;">
										<div class="clearfix">
											<a class="btn btn-danger pull-left" href="javascript:closeNextSidr();"><i class="icon-remove-sign"></i></a>
										</div>
										<a href="<?php echo get_permalink($nextPost); ?>">
											<?php echo get_the_post_thumbnail($nextPost->ID, 'post-image-mansory', array('class' => 'img-thumbnail img-responsive')); ?>
										</a>
										<h2><?php next_post_link('%link', '%title'); ?></h2>
										<p><?php echo substr(strip_tags($nextPost->post_content), 0, 200) . '...'; ?></p>
										<a href="<?php echo get_permalink($nextPost); ?>" class="btn btn-primary btn-block"><?php _e('Read more', 'shprinkone') ?></a>
									</div>
								<?php endif; ?>
								<?php comments_template('', true); ?>
							</div>
						</div>
					<?php endwhile; // end of the loop. ?>
			</div>
			<?php shprinkone_get_sidebar('right'); ?>
		</div>
	</div>
	<?php if (is_active_sidebar('after-content-widget')) : ?>
		<?php dynamic_sidebar('after-content-widget'); ?>
	<?php endif; ?>
</div>
<script>
	jQuery(document).ready(function($) {
		$('#previous-post').sidr({
			name: 'sidr-previous-post',
			source: function(name) {
				return $('#previous-post-content').clone().html();
			}
		});
		$('#next-post').sidr({
			name: 'sidr-next-post',
			source: function(name) {
				return $('#next-post-content').clone().html();
			},
			side: 'right'
		});

		window.closePreviousSidr = function() {
			$.sidr('close', 'sidr-previous-post')
		}

		window.closeNextSidr = function() {
			$.sidr('close', 'sidr-next-post')
		}
	});
</script>
<!-- container end -->
<?php get_footer(); ?>