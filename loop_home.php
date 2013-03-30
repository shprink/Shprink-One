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
<div id="slideshow"
	class="carousel slide">
	<ol class="carousel-indicators">
		<li data-target="#slideshow" data-slide-to="0" class="active"></li>
		<li data-target="#slideshow" data-slide-to="1"></li>
		<li data-target="#slideshow" data-slide-to="2"></li>
	</ol>
	<!-- Carousel items -->
	<div class="carousel-inner">
		<!-- Start the Loop. -->
		<?php while (have_posts() && $i <= 3) : the_post(); ?>
		<div class="item <?php if ($i === 1) echo 'active'; ?>">
			<div class="media">
				<?php if (has_post_thumbnail()): ?>
				<a class="pull-left post-thumbnail" href="<?php the_permalink() ?>"> <?php the_post_thumbnail('post-image-mansory', array('class' => 'img-polaroid')); ?>
				</a>
				<?php endif; ?>
				<div class="media-body">
					<h2 class="post-title">
						<a href="<?php the_permalink() ?>"
							title="<?php echo sprintf(__('Permanent Link to %s'), the_title_attribute()); ?>"><?php the_title(); ?>
						</a>
					</h2>
					<?php echo shprinkone_get_post_meta(true, false, true, true) ?>
					<?php the_excerpt(); ?>
					<div class="btn-group">
						<a class="post-more btn btn-large btn-primary" href="<?php the_permalink() ?>">
							<?php _e('Read more', 'shprinkone') ?>
						</a>
						<?php comments_popup_link(__('Leave a comment', 'shprinkone'), __('1 Comment', 'shprinkone'), __('% Comments', 'shprinkone'), 'btn btn-large'); ?>
					</div>
				</div>
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
