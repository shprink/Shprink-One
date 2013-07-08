<?php
/**
 * Default Loop
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */

$options    = shprinkone_get_theme_options();
if (defined('DISPLAYEDONSLIDESHOW') && !in_the_loop()) {
	for ($index = 0; $index < DISPLAYEDONSLIDESHOW; $index++) {
		$wp_query->next_post();
	}
}

if(defined('DISPLAYEDONSLIDESHOW') && isset($options['theme_slideshow']['copy_within_content'])){
	$wp_query->rewind_posts();
}
?>
<div id="masonry" class="masonry clearfix row">
	<!-- Start the Loop. -->
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('box') ?>>
				<div class="thumbnail modal-backdrop fade" style="display: none;">
					<?php if (has_post_thumbnail()): ?>
						<a href="<?php the_permalink() ?>">
							<div class="post-thumbnail">
								<?php the_post_thumbnail('post-image-mansory'); ?>
							</div>
						</a>
					<?php endif; ?>
					<div class="caption">
						<h3 class="post-title">
							<a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title_attribute(); ?>">
								<?php the_title(); ?>
							</a>
						</h3>
						<?php echo shprinkone_get_post_meta(false, true, true) ?>
						<hr />
						<?php comments_popup_link(__('Leave a comment', 'shprinkone'), __('1 Comment', 'shprinkone'), __('% Comments', 'shprinkone')); ?>
					</div>
				</div>
				<div class="thumbnail">
					<?php if (has_post_thumbnail()): ?>
						<a href="<?php the_permalink() ?>">
							<div class="post-thumbnail">
								<?php the_post_thumbnail('post-image-mansory'); ?>
							</div>
						</a>
					<?php endif; ?>
					<div class="caption">
						<h2 class="post-title">
							<a href="<?php the_permalink() ?>"
							   title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?>
							</a>
							<?php if (is_sticky()): ?>
								&nbsp;<span class="label label-info"><?php _e('Featured', 'shprinkone') ?></span>
							<?php endif ?>
						</h2>
						<div class="post-content">
							<?php the_excerpt(); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	<?php else: ?>
		<?php echo shprinkone_get_no_result(); ?>
	<?php endif; ?>
</div>
<div id="page-nav" style="display: none;">
	<?php if ($wp_query->max_num_pages > 1) next_posts_link(); ?>
</div>
<script>
	$(function() {

		/* Masonry */
		var $container = $('#masonry');

		// Callback on After new masonry boxes load
		var onAfterLoaded = function(el) {
			//$container.find('[rel="category tag"]').addClass('label label-important');
			//$container.find('[rel="tag"]').addClass('label label-info');

			el.on('mouseenter', function() {
				$(this).find('.modal-backdrop').show().addClass('in');
			}).on('mouseleave', function() {
				$(this).find('.modal-backdrop').removeClass('in');
			});
		};

		onAfterLoaded($container.find('.box'));

		$container.imagesLoaded(function() {
			$container.masonry({
				itemSelector: '.box'
			});

			$(window).resize(function() {
				$container.masonry('reload');
			});
		});

		$container.infinitescroll({
			navSelector: '#page-nav', // selector for the paged navigation
			nextSelector: '#page-nav a', // selector for the NEXT link (to page 2)
			itemSelector: '.box', // selector for all items you'll retrieve
			loading: {
				finishedMsg: '<?php echo __('No more pages to load.', 'shprinkone') ?>',
				img: '<?php echo get_stylesheet_directory_uri(); ?>/img/loading.gif'
			}
		},
		// trigger Masonry as a callback
		function(newElements) {
			// hide new items while they are loading
			var $newElems = $(newElements).css({
				opacity: 0});
			// ensure that images load before adding to masonry layout
			$newElems.imagesLoaded(function() {
				// show elems now they're ready
				$newElems.animate({
					opacity: 1});
				$container.masonry('appended', $newElems, true);
			});
			onAfterLoaded($newElems);

			// If the disqus plugin is enabled
			if (typeof DISQUSWIDGETS != 'undefined')
			{
				// Set the disqus hash
				var nodes = document.getElementsByTagName('span');
				for (var i = 0, url; i < nodes.length; i++) {
					if (nodes[i].className.indexOf('dsq-postid') != -1) {
						nodes[i].parentNode.setAttribute('data-disqus-identifier', nodes[i].getAttribute('rel'));
						url = nodes[i].parentNode.href.split('#', 1);
						if (url.length == 1)
							url = url[0];
						else
							url = url[1]
						nodes[i].parentNode.href = url + '#disqus_thread';
					}
				}
				DISQUSWIDGETS.getCount();
			}
		}
		);

	});
</script>
