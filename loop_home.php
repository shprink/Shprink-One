<?php
/**
 * Default Loop
 *
 * @subpackage  shprink_one
 * @since       1.0
 */
$displayedOnSlideshow = 0;
if (is_category()){
    $option_slideshow = shprinkone_get_theme_option('theme_slideshow_category');
} else if (is_tag()){
    $option_slideshow = shprinkone_get_theme_option('theme_slideshow_tag');
} else if (is_front_page()){
    $option_slideshow = shprinkone_get_theme_option('theme_slideshow');
}
$posts = $wp_query->get_posts();
?>
<?php if (have_posts() && get_query_var('paged') < 2) : ?>
	<div class="container-slideshow">
		<div id="slideshow" class="carousel slide">
			<!-- Carousel items -->
			<div class="carousel-inner">
				<!-- Start the Loop. -->
                <?php foreach ($posts as $post) : ?>
				<?php if ($displayedOnSlideshow >= $option_slideshow['posts']) break; ?>
					<div <?php
					$classes = 'item';
					if ($displayedOnSlideshow === 0)
						$classes .= ' active'; post_class($classes)
					?>>
						<div class="container">
							<div class="carousel-caption">
								<div class="media">
									<div class="media-body">
                                        <div class="title-wrapper">
                                        <?php if (has_post_thumbnail()): ?>
                                            <a class="post-thumbnail" href="<?php the_permalink() ?>">
                                                <?php the_post_thumbnail('post-image-mansory', array('class' => 'img-thumbnail img-responsive')); ?>
                                            </a>
                                        <?php endif; ?>
										<h2 class="post-title media-heading">
											<a href="<?php the_permalink() ?>"
											   title="<?php echo the_title_attribute(); ?>"><?php the_title(); ?>
											</a>
										</h2>
                                        <?php echo shprinkone_get_post_meta(true, true, true, false, false, true, true) ?>
                                        </div>


										<div class="post-content hidden-xs">
											<?php the_excerpt(); ?>
										</div>
										<div class="post-content visible-xs">
											<?php $excerpt = get_the_excerpt() ?>
											<?php echo ( $excerpt != '' ) ? substr($excerpt, 0, 150) . ' [...]' : '' ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php  $displayedOnSlideshow++; ?>
				<?php endforeach; ?>
			</div>

			<?php if ($option_slideshow['posts'] > 1 && count($posts) > 1): ?>
				<ol class="carousel-indicators">
					<?php for ($index = 0; $index < $displayedOnSlideshow; $index++): ?>
						<li data-target="#slideshow" data-slide-to="<?php echo $index ?>" class="<?php echo ($index === 0) ? 'active' : '' ?>"></li>
					<?php endfor; ?>
				</ol>
			<?php endif; ?>
			<?php if ($option_slideshow['posts'] > 1 && count($posts) > 1): ?>
				<!-- Carousel nav -->
				<a class="carousel-control left" href="#slideshow" data-slide="prev"><i class="icon-chevron-left"></i></a>
				<a class="carousel-control right" href="#slideshow" data-slide="next"><i class="icon-chevron-right"></i></a>
				<?php endif; ?>
		</div>
	</div>
	<?php define('DISPLAYEDONSLIDESHOW', $displayedOnSlideshow) ?>
	<script>
		jQuery(document).ready(function($) {
			/* Slideshow */
			$('#slideshow').carousel();
		});
	</script>
<?php endif; ?>