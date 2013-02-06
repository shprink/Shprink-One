<?php
/**
 * Default Loop
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
$i = 1;
?>
<?php if (have_posts() && get_query_var('paged') < 2) : ?>
	<div id="slideshow" class="carousel slide">
		<!-- Carousel items -->
		<div class="carousel-inner">
			<!-- Start the Loop. -->
			<?php while (have_posts() && $i <= 3) : the_post(); ?>
				<div class="item <?php if ($i === 1) echo 'active'; ?>">
					<?php if (has_post_thumbnail()): ?>
						<div class="post-thumbnail">
							<?php the_post_thumbnail('post-image-slideshow-' . shprinkone_get_imagespan()); ?>
						</div>
					<?php else: ?>
						<img src="<?php bloginfo('stylesheet_directory'); ?>/img/iPhoto.png" class="no-photo" />
					<?php endif; ?>
					<div class="carousel-caption span3">
						<h4 class="post-title"><a href="<?php the_permalink() ?>" title="<?php echo sprintf(__('Permanent Link to %s'), the_title_attribute()); ?>"><?php the_title(); ?></a></h4>
						<?php echo shprinkone_get_post_meta(true, true, true, true) ?>
						<?php the_excerpt(); ?>
						<hr/>
						<p><i class="icon-comment icon-white"></i> <?php comments_popup_link(__('Leave a comment', 'shprinkone'), __('1 Comment', 'shprinkone'), __('% Comments', 'shprinkone')); ?></p>
					</div>	
				</div>
				<?php $i++; ?>
			<?php endwhile; ?>
		</div>
		<!-- Carousel nav -->
		<a class="carousel-control left" href="#slideshow" data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#slideshow" data-slide="next">&rsaquo;</a>
	</div>
<?php endif; ?>

<script>
	$(function(){
		/* Slideshow */
		$('#slideshow').carousel();
	});
</script>