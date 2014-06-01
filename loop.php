<?php
/**
 * Default Loop
 *
 * @subpackage  shprink_one
 * @since       1.0
 */
$options = shprinkone_get_theme_options();
$option_loop = shprinkone_get_theme_option('theme_loop');
if (is_category()){
    $option_slideshow = shprinkone_get_theme_option('theme_slideshow_category');
} else if (is_tag()){
    $option_slideshow = shprinkone_get_theme_option('theme_slideshow_tag');
} else if (is_front_page()){
    $option_slideshow = shprinkone_get_theme_option('theme_slideshow');
}

if (defined('DISPLAYEDONSLIDESHOW') && !in_the_loop()) {
	for ($index = 0; $index < DISPLAYEDONSLIDESHOW; $index++) {
		$wp_query->next_post();
	}
}

if (defined('DISPLAYEDONSLIDESHOW') && isset($option_slideshow['copy_within_content']) && $option_slideshow['copy_within_content']) {
	$wp_query->rewind_posts();
}

$displayMeta = false;
if (isset($options['theme_posts']['meta']) && $options['theme_posts']['meta']) {
	$displayMeta = true;
}
?>
<div id="masonry" class="masonry clearfix row">
	<!-- Start the Loop. -->
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('col-sm-6 col-md-6 col-lg-4 box') ?>>
				<div class="panel panel-default">
                    <?php if ($option_loop['comment']): ?>
                        <a class="post-comments label <?php echo get_comments_number()? 'label-danger' : 'label-default' ?>" href="<?php comments_link(); ?>">
                            <?php comments_number( '0', '1', '%' ); ?>
                        </a>
                    <?php endif; ?>
					<?php if (has_post_thumbnail()): ?>
						<a href="<?php the_permalink() ?>">
							<div class="post-thumbnail">
								<?php the_post_thumbnail('post-image-mansory', array('class' => 'img-responsive')); ?>
							</div>
						</a>
					<?php endif; ?>
					<div class="panel-body">
                        <?php if ($option_loop['date']): ?>
                        <div class="calendar-wrapper panel panel-default">
                            <div class="panel-body">
                            <?php shprinkone_get_calendar(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
						<h3 class="post-title">
							<?php $hasTitle = the_title(null, null, false) !== null ?>
							<a href="<?php the_permalink() ?>"
							   title="<?php echo the_title_attribute(); ?>"><?php echo $hasTitle ? the_title(null, null, true) : __('Read more', 'shprinkone'); ?>
							</a>
						</h3>

						<div class="post-content">
							<?php the_excerpt(); ?>
						</div>
						<?php if ($displayMeta): ?>
							<div class="well well-sm">
								<?php echo shprinkone_get_post_meta(true, true, false, true, true, false, true, true) ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	<?php else: ?>
		<?php echo shprinkone_get_no_result(); ?>
	<?php endif; ?>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		/* Masonry */
		var $container = $('#masonry');

		// Callback on After new masonry boxes load
		window.onAfterLoaded = function(el) {
			el.find('div.post-meta li').popover({
				trigger: 'hover',
				placement: 'top',
				container: 'body'
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
	});
</script>
<?php if (isset($options['theme_posts']['type']) && $options['theme_posts']['type'] == 'ajax_scroll'): ?>
	<div id="page-nav" style="display: none;">
		<?php if ($wp_query->max_num_pages > 1) next_posts_link(); ?>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var $container = $('#masonry');
			$container.infinitescroll({
				navSelector: '#page-nav', // selector for the paged navigation
				nextSelector: '#page-nav a', // selector for the NEXT link (to page 2)
				itemSelector: '.box', // selector for all items you'll retrieve,
				loading: {
					finishedMsg: '<?php echo __('No more pages to load.', 'shprinkone') ?>',
					img: '<?php echo get_stylesheet_directory_uri(); ?>/img/loading.gif',
					msgText: '<?php echo __('Loading the next set of posts...', 'shprinkone') ?>'
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
			}
			);
		});
	</script>
<?php elseif (isset($options['theme_posts']['type']) && $options['theme_posts']['type'] === 'ajax_button'): ?>

	<div id="page-nav">
		<?php
		if (get_next_posts_link()) {
			echo '<a class="btn btn-primary btn-large btn-block" href="javascript:void(0)" data-href="' . next_posts($wp_query->max_num_pages, false) . '">' . __('Older posts', 'shprinkone') . '</a>';
		}
		?>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var loading = {
				finishedMsg: '<?php echo __('No more pages to load.', 'shprinkone') ?>',
				img: '<?php echo get_stylesheet_directory_uri(); ?>/img/loading.gif',
				msgText: '<?php echo __('Loading the next set of posts...', 'shprinkone') ?>'
			}

			var $container = $('#masonry');
			$('#page-nav a').click(function() {
				$button = $(this);
				if (typeof $button.data('href') === 'string' && $button.data('href') !== '') {
					var buttonHtml = $button.html();
					$button.attr('disabled', 'disabled');
					$button.html('<i class="icon-spinner icon-spin"></i> ' + loading.msgText);
					$.ajax($button.data('href'))
							.done(function(data, textStatus, jqXHR) {
						// Set the new page href
						$button.data('href', $(data).find('#page-nav a').data('href'));

						var $newElems = $(data).find('.box').css({
							opacity: 0});
						// ensure that images load before adding to masonry layout
						$newElems.imagesLoaded(function() {
							// show elems now they're ready
							$newElems.animate({
								opacity: 1});
							$container.prepend($newElems);
							$container.masonry('appended', $newElems, true);
						});
						onAfterLoaded($newElems);
					})
							.fail(function(jqXHR, textStatus, errorThrown) {
						$error = $('<div class="alert alert-danger">Something wrong happened :(</div>');
						$error.insertAfter($button);
						$button.remove();
						setTimeout(function() {
							$error.remove()
						}, 3000);
					})
							.always(function() {
						$button.html(buttonHtml);
						$button.removeAttr('disabled');
					});
				}
				else {
					$finish = $('<div class="alert alert-info">' + loading.finishedMsg + '</div>').hide();
					$finish.insertAfter($button);
					$finish.show(500);
					$button.remove();
					setTimeout(function() {
						$finish.hide(500, function() {
							$finish.remove()
						});
					}, 3000)
				}

			});
		});
	</script>
<?php elseif (isset($options['theme_posts']['type']) && $options['theme_posts']['type'] === 'default'): ?>
	<div id="page-nav">
		<div class="row">
			<div class="col-md-6 col-lg-6 col-sm-6">
				<?php if (get_next_posts_link()) : ?>
					<a class="nav-previous btn btn-primary btn-large btn-block" href="<?php echo next_posts($wp_query->max_num_pages, false) ?>"><i class="icon-chevron-left"></i> <?php _e('Older posts', 'shprinkone') ?></a>
				<?php endif; ?>
			</div>

			<div class="col-md-6 col-lg-6 col-sm-6">
				<?php if (get_previous_posts_link()) : ?>
					<a class="nav-next btn btn-primary btn-large btn-block" href="<?php echo previous_posts(false); ?>"><?php _e('Newer posts', 'shprinkone'); ?> <i class="icon-chevron-right"></i> </a>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>
