<?php
/**
 * Template footer
 *
 * @subpackage  shprink_one
 * @since       1.0
 */
$condition = is_active_sidebar('footer-widget-left') || is_active_sidebar('footer-widget-middle-left') || is_active_sidebar('footer-widget-middle-right') || is_active_sidebar('footer-widget-right');
$selectedTemplate = shprinkone_get_selected_template();
if ($selectedTemplate['value'] == 'cupid') {
	$copyright = __('All You Need Is %s | by %s', 'shprinkone');
	$copyrightIcon = '<i class="icon-heart"></i>';
} else {
	$copyright = __('%s Theme created by %s', 'shprinkone');
	$copyrightIcon = '<i class="icon-certificate icon-white"></i>';
}
?>
<?php if ($condition) : ?>
	<footer id="footer" class="well well-small">
		<div class="footer-inner">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-lg-3">
						<?php if (is_active_sidebar('footer-widget-left')) : ?>
							<?php dynamic_sidebar('footer-widget-left'); ?>
						<?php endif; ?>
					</div>
					<div class="col-md-3 col-lg-3">
						<?php if (is_active_sidebar('footer-widget-middle-left')) : ?>
							<?php dynamic_sidebar('footer-widget-middle-left'); ?>
						<?php endif; ?>
					</div>
					<div class="col-md-3 col-lg-3">
						<?php if (is_active_sidebar('footer-widget-middle-right')) : ?>
							<?php dynamic_sidebar('footer-widget-middle-right'); ?>
						<?php endif; ?>
					</div>
					<div class="col-md-3 col-lg-3">
						<?php if (is_active_sidebar('footer-widget-right')) : ?>
							<?php dynamic_sidebar('footer-widget-right'); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</footer>
<?php endif; ?>
<section id="credit">
	<div class="credit-inner">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<div class="pull-left">
						&copy;
						<?php echo date("Y"); ?>
						<?php bloginfo('name'); ?>
						<?php _e('All rights reserved.', 'shprinkone') ?>
						| Powered by <a href="http://wordpress.org/">WordPress</a>
					</div>

					<div class="pull-right">
						<?php printf($copyright, $copyrightIcon, '<a href="http://julienrenaux.fr" target="_blank">@julienrenaux</a>') ?>
					</div>
					<?php if (is_active_sidebar('footer-widget-bottom')) : ?>
						<?php dynamic_sidebar('footer-widget-bottom'); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php wp_footer(); ?>
</body>
</html>
