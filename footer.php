<?php
/**
 * Template footer
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>
<footer id="footer">
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
</footer>
<section id="credit">
	<div class="container">
		<div class="row">
			<div class="span12">
				<ul class="inline">
					<li>
						<?php _e('Copyright', 'shpinkone'); ?> &copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>
						| Powered by <a href="http://wordpress.org/">WordPress</a>
					</li>
					<li>
						<?php if (is_active_sidebar('footer-widget-bottom')) : ?>
							<?php dynamic_sidebar('footer-widget-bottom'); ?>
						<?php endif; ?>
					</li>
					<li class="pull-right">
						<i class="icon-certificate"></i> Theme created by <a href="http://julienrenaux.fr/shprinkone" target="_blank">Shprink.</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>
<script>
	$(function(){
		// TODO
	});
</script>
<?php wp_footer(); ?>
</body>
</html>
