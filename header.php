<?php
/**
 * Template header
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
$selectedTemplate = shprinkone_get_selected_template();
global $page, $paged;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php wp_title('|', true, 'right'); ?></title>

		<?php
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */
		if (is_singular() && get_option('thread_comments'))
			wp_enqueue_script('comment-reply');

		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
		?>
		<script type="text/javascript">
			var $ = jQuery;
		</script>
	</head>
	<body <?php body_class('theme-' . $selectedTemplate['value']); ?> data-spy="scroll" data-target=".navbar">
		<header id="header">
			<div class="navbar navbar-default navbar-fixed-top" role="navigation">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>"><i
								class="icon-home icon-white"> </i> <?php echo bloginfo('name'); ?>
						</a>
					</div>
					<div class="collapse navbar-collapse navbar-ex1-collapse">
						<?php
						// Primary menu
						wp_nav_menu(array(
							'theme_location' => 'primary',
							'depth' => 3,
							'container' => false,
							'menu_class' => 'nav navbar-nav',
							'walker' => new Bootstrap_Walker_Nav_Menu(),
							'fallback_cb' => null
						));
						?>

						<ul class="nav navbar-nav navbar-right">
							<li><?php get_search_form(); ?></li>
							<li>
								<a href="<?php echo esc_url(home_url('?feed=rss2')); ?>"
								   title="<?php _e('Subscribe to the RSS feed', 'shprinkone') ?>">
									<i class="icon-rss"> </i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</header>