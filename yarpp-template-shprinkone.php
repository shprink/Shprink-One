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
				<div class="col-lg-3 col-md-3">
					<a href="<?php echo get_permalink() ?>" class="thumbnail">
						<?php if (has_post_thumbnail()): ?>
							<?php the_post_thumbnail('post-image-mansory', array('class' => 'img-responsive')); ?>
						<?php endif; ?>
						<div class="caption">
							<p><?php echo get_the_title() ?></p>
						</div>
					</a>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
<?php endif; ?>