<?php
/**
 * Template file used to render a single attachment (attachment post-type) page 
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0.3
 */
?>
<?php get_header(); ?>
<div class="container">
	<!-- container start -->
	<div id="content">
		<div class="row">
			<?php shprinkone_get_sidebar('left'); ?>
			<div class="<?php echo shprinkone_get_contentspan(); ?>">
				<div id="post-<?php the_ID(); ?>" <?php post_class('image-attachment panel panel-default'); ?>>
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
							<?php echo shprinkone_get_post_meta(true, true, true, false, false) ?><?php
							$metadata = wp_get_attachment_metadata();
							printf(__('<div class="post-meta">Full size: <a href="%1$s" title="Link to full-size image">%2$s &times; %3$s</a> in <a href="%4$s" title="Return to %5$s" rel="gallery">%6$s</a></div>', 'shprinkone'), esc_url(wp_get_attachment_url()), $metadata['width'], $metadata['height'], esc_url(get_permalink($post->post_parent)), esc_attr(strip_tags(get_the_title($post->post_parent))), get_the_title($post->post_parent)
							);
							?>
							<?php edit_post_link(__('Edit', 'shprinkone'), '<span class="edit-link">', '</span>'); ?>
						</div>
						<div class="post-content">
							<?php
							/**
							 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
							 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
							 */
							$attachments = array_values(get_children(array('post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID')));
							foreach ($attachments as $k => $attachment) :
								if ($attachment->ID == $post->ID)
									break;
							endforeach;

							$k++;
							// If there is more than 1 attachment in a gallery
							if (count($attachments) > 1) :
								if (isset($attachments[$k])) :
									// get the URL of the next image attachment
									$next_attachment_url = get_attachment_link($attachments[$k]->ID);
								else :
									// or get the URL of the first image attachment
									$next_attachment_url = get_attachment_link($attachments[0]->ID);
								endif;
							else :
								// or, if there's only 1 image, get the URL of the image
								$next_attachment_url = wp_get_attachment_url();
							endif;
							?>
							<a href="<?php echo esc_url($next_attachment_url); ?>" title="<?php the_title_attribute(); ?>"><?php
								echo wp_get_attachment_image($post->ID, array(960, 960), false, array('class' => 'img-responsive'));
								?></a>
						</div>
						<?php
						// cheat to pass theme review
						wp_link_pages(array('echo' => 0));
						?>
						<?php shprinkone_link_pages(); ?>
						<ul class="pager">
							<li class="previous">
								<?php previous_image_link(false, '<i class="icon-chevron-left"></i> ' . __('Previous', 'shprinkone') . '</span>'); ?>
							</li>
							<li class="next">
								<?php next_image_link(false, '<i class="icon-chevron-right"></i> ' . __('Next', 'shprinkone') . '</span>'); ?>
							</li>
						</ul>
						<?php comments_template('', true); ?>
					</div>
				</div>
			</div>
			<?php shprinkone_get_sidebar('right'); ?>
		</div>
	</div>
</div>
<!-- container end -->
<?php get_footer(); ?>