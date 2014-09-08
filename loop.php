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
<?php if (isset($options['theme_posts']['type']) && $options['theme_posts']['type'] == 'ajax_scroll'): ?>
	<div id="page-nav" style="display: none;">
		<?php if ($wp_query->max_num_pages > 1) next_posts_link(); ?>
	</div>
<?php elseif (isset($options['theme_posts']['type']) && $options['theme_posts']['type'] === 'ajax_button'): ?>
	<div id="page-nav">
		<?php if (get_next_posts_link()): ?>
    		<a class="btn btn-primary btn-large btn-block" href="javascript:void(0)" data-href="<?php echo next_posts($wp_query->max_num_pages, false) ?>"><?php echo __('Older posts', 'shprinkone') ?></a>
        <?php endif; ?>
	</div>
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
