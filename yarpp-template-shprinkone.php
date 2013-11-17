<?php
/*
  YARPP Template: Shprinkone
  Description: YARPP's wrap for Shprinkone theme
  Author: shprink (Julien Renaux)
 */
?>
<?php if (have_posts()): ?>
	<div class="page-header">
		<h2><?php _e('Related posts', 'shprinkone') ?></h2>
	</div>
	<div class="well yarpp-template">
		<div class="row">
			<?php while (have_posts()) : the_post(); ?>
				<div class="col-lg-3 col-md-3 col-sm-6">
					<a href="<?php echo get_permalink() ?>" class="thumbnail">
						<?php if (has_post_thumbnail()): ?>
							<?php the_post_thumbnail('post-image-mansory', array('class' => 'img-responsive')); ?>
						<?php endif; ?>
						<div class="caption">
							<h3><?php echo get_the_title() ?></h3>
							<p><?php echo get_the_excerpt() ?></p>
						</div>
					</a>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
<?php endif; ?>