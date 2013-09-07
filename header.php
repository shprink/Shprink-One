<?php
/**
 * Template header
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
$templateList = shprinkone_get_theme_templates();
if (isset($_GET["shprinkone-theme"]) && in_array(strtolower($_GET["shprinkone-theme"]), array_keys($templateList))) {
	$selectedTemplate = $templateList[strtolower($_GET["shprinkone-theme"])];
	setcookie('shprinkone-theme', strtolower($_GET["shprinkone-theme"]), time() + 86400); // 24 hours
} else {
	if (isset($_COOKIE['shprinkone-theme'])) {
		$selectedTemplate = $templateList[$_COOKIE['shprinkone-theme']];
	} else {
		$selectedTemplate = shprinkone_get_selected_template();
	}
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php
/*
 * Print the <title> tag based on what is being viewed.
 */
global $page, $paged;

wp_title('|', true, 'right');

// Add the blog name.
bloginfo('name');
?>
		</title>
		<link rel="stylesheet" type="text/css"
			  href="<?php echo get_stylesheet_directory_uri() . $selectedTemplate['path']; ?>">
		<link rel="stylesheet" type="text/css"
			  href="<?php echo get_stylesheet_directory_uri(); ?>/css/jquery.sidr.light.css">
		<link rel="stylesheet" type="text/css"
			  href="<?php echo get_stylesheet_directory_uri(); ?>/css/jquery.sidr.light.css">
		<link rel="stylesheet" type="text/css" media="all"
			  href="<?php bloginfo('stylesheet_url'); ?>" />

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
		<script type="text/javascript"
		src="<?php echo get_stylesheet_directory_uri(); ?>/js/bootstrap.min.js"></script>
		<script type="text/javascript"
		src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.infinitescroll.min.js"></script>
		<script type="text/javascript"
		src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.sidr.min.js"></script>
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
$args = array(
	'depth' => 3,
	'container' => false,
	'menu_class' => 'nav navbar-nav',
	'walker' => new Bootstrap_Walker_Nav_Menu(),
	'fallback_cb' => null
);
wp_nav_menu($args);
?>

						<ul class="nav navbar-nav navbar-right">
<?php if (has_nav_menu('header-menu-right')): ?>
								<li><?php
								$args = array(
									'theme_location' => 'header-menu-right',
									'depth' => 3,
									'container' => false,
									'menu_class' => 'nav',
									'walker' => new Bootstrap_Walker_Nav_Menu()
								);
								wp_nav_menu($args);
								?>
								</li>
								<?php endif; ?>
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