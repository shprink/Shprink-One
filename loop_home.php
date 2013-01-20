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
						<div class="post-thumbnail img-polaroid">
							<?php shprinkone_get_calendar(); ?>
							<?php the_post_thumbnail('post-image-slideshow'); ?>
						</div>
					<?php else: ?>
						<img src="<?php bloginfo('stylesheet_directory'); ?>/img/iPhoto.png" class="no-photo" />
					<?php endif; ?>
					<div class="carousel-caption">
						<h4 class="post-title"><a href="<?php the_permalink() ?>" title="<?php echo sprintf(__('Permanent Link to %s'), the_title_attribute()); ?>"><?php the_title(); ?></a></h4>
						<?php echo shprinkone_get_post_meta(true, true) ?>
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
<div id="masonry" class="masonry clearfix row">
	<!-- Start the Loop. -->
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" class="box">
				<div class="well">
					<?php if (has_post_thumbnail()): ?>
						<div class="post-thumbnail img-polaroid">
							<?php shprinkone_get_calendar(); ?>
							<?php the_post_thumbnail('post-image-mansory'); ?>
						</div>
					<?php endif; ?>
					<h2 class="post-title">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					</h2>
					<div class="post-content">
						<?php the_excerpt(); ?>
					</div>
					<?php echo shprinkone_get_post_meta() ?>
					<hr/>
					<p><i class="icon-comment"></i> <?php comments_popup_link(__('Leave a comment', 'shprinkone'), __('1 Comment', 'shprinkone'), __('% Comments', 'shprinkone')); ?></p>
				</div>
			</div>
		<?php endwhile; ?>
	<?php else: ?>
		<?php echo shprinkone_get_no_result();  ?>
	<?php endif; ?>
</div>
<div id="page-nav" style="display: none;">
	<?php if ($wp_query->max_num_pages > 1) next_posts_link(); ?>
</div>
<script>
	$(function(){
		
		/* Slideshow */
		$('#slideshow').carousel();
		
		/* Masonry */
		var $container = $('#masonry');

		// Callback on After new masonry boxes load
		var onAfterLoaded = function(){
			//$container.find('[rel="category tag"]').addClass('label label-important');
			//$container.find('[rel="tag"]').addClass('label label-info');
		};

		onAfterLoaded();

		$container.imagesLoaded(function(){
			$container.masonry({
				itemSelector: '.box'
			});
			
			$(window).resize(function() {
				$container.masonry( 'reload' );
			});
		});

		$container.infinitescroll({
			navSelector  : '#page-nav',    // selector for the paged navigation
			nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
			itemSelector : '.box',     // selector for all items you'll retrieve
			loading: {
				finishedMsg: '<?php echo __('No more pages to load.', 'shprinkone') ?>',
				img: '<?php bloginfo('stylesheet_directory'); ?>/img/loading.gif'
			}
		},
		// trigger Masonry as a callback
		function( newElements ) {
			// hide new items while they are loading
			var $newElems = $( newElements ).css({
				opacity: 0 });
			// ensure that images load before adding to masonry layout
			$newElems.imagesLoaded(function(){
				// show elems now they're ready
				$newElems.animate({
					opacity: 1 });
				$container.masonry( 'appended', $newElems, true );
			});
			onAfterLoaded();

			// If the disqus plugin is enabled
			if (typeof DISQUSWIDGETS != 'undefined')
			{
				// Set the disqus hash
				var nodes = document.getElementsByTagName('span');
				for (var i = 0, url; i < nodes.length; i++) {
					if (nodes[i].className.indexOf('dsq-postid') != -1) {
						nodes[i].parentNode.setAttribute('data-disqus-identifier', nodes[i].getAttribute('rel'));
						url = nodes[i].parentNode.href.split('#', 1);
						if (url.length == 1) url = url[0];
						else url = url[1]
						nodes[i].parentNode.href = url + '#disqus_thread';
					}
				}
				DISQUSWIDGETS.getCount();
			}
		}
	);

	});
</script>