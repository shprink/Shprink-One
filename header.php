<?php
/**
 * Template header
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
$selectedTemplate = shprinkone_get_selected_template();
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
<link rel="stylesheet" type="text/css" media="all"
	href="<?php bloginfo('stylesheet_url'); ?>" />
<script type="text/javascript"
	src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript"
	src="<?php echo get_stylesheet_directory_uri(); ?>/js/bootstrap.min.js"></script>
<script type="text/javascript"
	src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.masonry.min.js"></script>
<script type="text/javascript"
	src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.infinitescroll.min.js"></script>

<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>
<body <?php body_class(); ?> data-spy="scroll" data-target=".navbar">
	<header id="header">
		<div class="navbar navbar-inverse navbar-header navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="<?php echo esc_url(home_url('/')); ?>"><i
						class="icon-home icon-white"> </i> <?php echo bloginfo('name'); ?>
					</a>
					<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
					<a class="btn btn-navbar" data-toggle="collapse"
						data-target=".nav-collapse"> <span class="icon-bar"></span> <span
						class="icon-bar"></span> <span class="icon-bar"></span>
					</a>
					<!-- Everything you want hidden at 940px or less, place within here -->
					<div class="nav-collapse collapse">
						<?php
						// Primary menu
						$args = array(
								'depth' => 3,
								'container' => false,
								'menu_class' => 'nav',
								'walker' => new Bootstrap_Walker_Nav_Menu(),
								'fallback_cb' => null
							);
							wp_nav_menu($args);
							?>
						<ul class="nav pull-right">
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
							<li class="divider-vertical"></li>
							<li><?php get_search_form(); ?>
							</li>
							<li><a href="<?php echo esc_url(home_url('?feed=rss2')); ?>"
								title="<?php _e('Subscribe to the RSS feed', 'shprinkone') ?>">
									<i class="icon-rss"> </i>
							</a>
							</li>
						</ul>

					</div>
				</div>
			</div>
		</div>
		<script>
				$(function(){
					// Add Bootstrap class to lists within the sidebar
					$('#sidebar .widget ul').addClass('nav nav-pills nav-stacked');
					$('footer .widget ul').addClass('nav nav-pills nav-stacked');
					$('.widget_recent_comments ul').removeClass('nav nav-tabs nav-pills nav-stacked').addClass('unstyled');
				});
			</script>
	</header>