<?php
/**
 * Template footer
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
$condition = is_active_sidebar('footer-widget-left') 	|| is_active_sidebar('footer-widget-middle-left') || is_active_sidebar('footer-widget-middle-right') || is_active_sidebar('footer-widget-right');
?>
<?php if ($condition) : ?>
<footer id="footer" class="well well-small">
	<div class="footer-inner">
		<div class="container">
			<div class="row">
				<div class="span3">
					<?php if (is_active_sidebar('footer-widget-left')) : ?>
					<?php dynamic_sidebar('footer-widget-left'); ?>
					<?php endif; ?>
				</div>
				<div class="span3">
					<?php if (is_active_sidebar('footer-widget-middle-left')) : ?>
					<?php dynamic_sidebar('footer-widget-middle-left'); ?>
					<?php endif; ?>
				</div>
				<div class="span3">
					<?php if (is_active_sidebar('footer-widget-middle-right')) : ?>
					<?php dynamic_sidebar('footer-widget-middle-right'); ?>
					<?php endif; ?>
				</div>
				<div class="span3">
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
				<div class="span12">
					<div class="pull-left">
						&copy;
						<?php echo date("Y"); ?>
						<?php bloginfo('name'); ?>
						<?php _e('All rights reserved.', 'shprinkone') ?>
						| Powered by <a href="http://wordpress.org/">WordPress</a>
					</div>

					<div class="pull-right">
						<i class="icon-certificate icon-white"></i> Theme created by <a
							href="http://julienrenaux.fr/shprinkone" target="_blank">Shprink.</a>
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