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
				<?php if ( is_active_sidebar( 'footer-widget-left' ) ) : ?>
					<?php dynamic_sidebar( 'footer-widget-left' ); ?>
				<?php endif; ?>
			</div>
			<div class="span3">
				<?php if ( is_active_sidebar( 'footer-widget-middle-left' ) ) : ?>
					<?php dynamic_sidebar( 'footer-widget-middle-left' ); ?>
				<?php endif; ?>
			</div>
			<div class="span3">
				<?php if ( is_active_sidebar( 'footer-widget-middle-right' ) ) : ?>
					<?php dynamic_sidebar( 'footer-widget-middle-right' ); ?>
				<?php endif; ?>
			</div>
			<div class="span3">
				<?php if ( is_active_sidebar( 'footer-widget-right' ) ) : ?>
					<?php dynamic_sidebar( 'footer-widget-right' ); ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="row-fluid credit">
			<div class="span12">
				<?php printf( __( 'Proudly powered by %s', 'shprinkone' ), 'WordPress' ); ?>
				<?php if ( is_active_sidebar( 'footer-widget-bottom' ) ) : ?>
					<?php dynamic_sidebar( 'footer-widget-bottom' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</footer>
<script>
$(function(){
	// TODO
});
</script>
<?php wp_footer(); ?>
</body>
</html>
