<?php
/**
 * Default Loop
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>

<!-- Start the Loop. -->
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<!--   
		<div class="thumbnail box">
            <?php if (has_post_thumbnail()): ?>
            	<?php shprinkone_get_calendar();  ?>
				<?php the_post_thumbnail('post-image-mansory');?>
			<?php endif; ?>
            <div class="caption">
				<h3>
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>				
				</h3>
				<p><?php the_excerpt(); ?></p>
				<p><a class="btn btn-primary" href="#">Action</a> <a class="btn" href="#">Action</a></p>
			</div>
		</div>
		-->
		<div id="post-<?php the_ID(); ?>" class="box well">
			<?php if (has_post_thumbnail()): ?>
			<div class="post-thumbnail img-polaroid">
				<?php shprinkone_get_calendar();  ?>
				<?php the_post_thumbnail('post-image-mansory');?>
			</div>
			<?php endif; ?>
			 <h2 class="post-title">
			 	<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			 </h2>			 
<!-- 			<div class="post-date">
				<i class="icon-calendar"></i><?php the_time('F jS, Y') ?>
 			</div> -->
			<div class="post-content">
				<?php the_excerpt(); ?>
			</div>
			<div class="post-meta">				
				<div class="post-author">
					<i class="icon-user"></i> by <?php the_author_posts_link() ?>
				</div>
				<?php if (has_category()): ?>
				<hr/>
				<div class="post-category">
					<i class="icon-folder-open"></i> Category: <?php the_category(' '); ?>
				</div>
				<?php endif; ?>
				<?php if (has_tag()): ?>
				<hr/>
				<p class="post-tags"><i class="icon-tags"></i> <?php the_tags(null, ' '); ?></p>
				<?php endif; ?>
				<hr/>
				<?php comments_popup_link( __( 'Leave a comment', 'shprinkone'), __( '1 Comment', 'shprinkone'), __( '% Comments', 'shprinkone') ); ?>
			</div>
		</div>
		<?php endwhile; else: ?>
		
		<p>Sorry, no posts matched your criteria.</p>
		<?php endif; ?>
		<?php if ( $wp_query->max_num_pages > 1 ) : ?>
		<div id="page-nav" style="display: none;">
			<?php next_posts_link(); ?>
		</div><!-- #nav-above -->
	<?php endif; ?>
	
<script>
$(function(){

	var $container = $('#post-container');

	var onAfterLoaded = function(){
		$container.find('[rel="category tag"]').addClass('label label-important');
		$container.find('[rel="tag"]').addClass('label label-info');
	};

	onAfterLoaded();

	$container.imagesLoaded(function(){
		$container.masonry({
			itemSelector: '.box'
		});
		//$container.find('.box')
		$container.find('.box').mouseenter(function(){
			//$(this).addClass('hover');
			//$container.masonry( 'reload' );
			//$(this).effect('slide', {}, 500);

		}).mouseleave(function(){
			//$(this).removeClass('hover');
			//$container.masonry( 'reload' );
			//$(this).hide();
		});
	});

	$container.infinitescroll({
		navSelector  : '#page-nav',    // selector for the paged navigation
		nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
		itemSelector : '.box',     // selector for all items you'll retrieve
		loading: {
			finishedMsg: 'No more pages to load.',
			img: 'http://i.imgur.com/6RMhx.gif'
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
					/*
					$newElems.hover(function(){
						$container.masonry( 'reload' )
					});
					*/
			});
			onAfterLoaded();
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
	);

});
</script>