<?php
/**
 * Default Loop
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
$displayedOnSlideshow = 0;
$options    = shprinkone_get_theme_options();
?>
<?php if (have_posts() && get_query_var('paged') < 2) : ?>
<div id="slideshow"
	class="carousel slide">
	<!-- Carousel items -->
	<div class="carousel-inner">
		<!-- Start the Loop. -->
		<?php while (have_posts() && $displayedOnSlideshow < $options['theme_slideshow']['posts']) : the_post(); ?>
		<div <?php $classes = 'item'; if ($displayedOnSlideshow === 0) $classes .= ' active' ; post_class($classes) ?>>
			<div class="media">
				<?php if (has_post_thumbnail()): ?>
				<a class="post-thumbnail" href="<?php the_permalink() ?>">
					<?php the_post_thumbnail('post-image-mansory', array('class' => 'img-polaroid')); ?>
				</a>
				<?php endif; ?>
				<div class="media-body">
					<h2 class="post-title">
						<a href="<?php the_permalink() ?>"
							title="<?php echo sprintf(__('Permanent Link to %s', 'shprinkone'), the_title_attribute()); ?>"><?php the_title(); ?>
						</a>
						<?php if (is_sticky()): ?>
							&nbsp;<span class="label label-info"><?php _e( 'Featured', 'shprinkone' ) ?></span>
						<?php endif ?>
					</h2>
					<?php echo shprinkone_get_post_meta(true, true, true, false, false) ?>
					<div class="post-content hidden-phone">
						<?php the_excerpt(); ?>
					</div>
					<div class="post-content visible-phone">
						<?php $excerpt = get_the_excerpt() ?>
						<?php echo ( $excerpt != '' )? substr($excerpt, 0, 150) . ' [...]' : '' ?>
					</div>
					<div class="btn-group hidden-phone">
						<a class="post-more btn btn-large btn-primary" href="<?php the_permalink() ?>">
							<?php _e('Read more', 'shprinkone') ?>
						</a>
						<?php comments_popup_link(__('Leave a comment', 'shprinkone'), __('1 Comment', 'shprinkone'), __('% Comments', 'shprinkone'), 'btn btn-large'); ?>
					</div>
					<div class="btn-group visible-phone text-center">
						<a class="post-more btn btn-large btn-primary" href="<?php the_permalink() ?>">
							<?php _e('Read more', 'shprinkone') ?>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php $displayedOnSlideshow++; ?>
		<?php endwhile; ?>
	</div>
	
	<?php if ($options['theme_slideshow']['posts'] > 1): ?>
	<ol class="carousel-indicators">
		<?php for ($index = 0; $index < $displayedOnSlideshow; $index++): ?>
		<li data-target="#slideshow" data-slide-to="<?php echo $index ?>" class="<?php echo ($index === 0)? 'active' : '' ?>"></li>
		<?php endfor; ?>
	</ol>
	<?php endif; ?>
	<?php if ($options['theme_slideshow']['posts'] > 1): ?>
	<!-- Carousel nav -->
	<a class="carousel-control left" href="#slideshow" data-slide="prev">&lsaquo;</a>
	<a class="carousel-control right" href="#slideshow" data-slide="next">&rsaquo;</a>
	<?php endif; ?>
</div>
<?php endif; ?>
<?php define('DISPLAYEDONSLIDESHOW', $displayedOnSlideshow) ?>
<script>
	$(function(){
		/* Slideshow */
		$('#slideshow').carousel();
	});
</script>
