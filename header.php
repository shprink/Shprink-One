<?php
/**
 * Template header
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>
<!DOCTYPE html>
<html   <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
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
		<link rel="stylesheet" type="text/css" media="all"
			  href="<?php bloginfo('stylesheet_url'); ?>" />
		<script type="text/javascript"
		src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript"
		src="<?php bloginfo('stylesheet_directory'); ?>/js/bootstrap.min.js"></script>
		<script type="text/javascript"
		src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript"
		src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.infinitescroll.min.js"></script>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<header id="header">
			<div class="navbar navbar-header navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="brand" href="<?php echo esc_url(home_url('/')); ?>"><i class="icon-home icon-white"> </i> <?php echo bloginfo('name'); ?></a>
						<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						<!-- Everything you want hidden at 940px or less, place within here -->
						<div class="nav-collapse collapse">
							<?php
							// Primary menu
							$args = array(
								'depth' => 2,
								'container' => false,
								'menu_class' => 'nav',
								'walker' => new Bootstrap_Walker_Nav_Menu()
							);
							wp_nav_menu($args);
							?>
							<ul class="nav pull-right">
								<?php if (has_nav_menu('header-menu-right')): ?>
									<li>
										<?php
										$args = array(
											'theme_location' => 'header-menu-right',
											'depth' => 2,
											'container' => false,
											'menu_class' => 'nav',
											'walker' => new Bootstrap_Walker_Nav_Menu()
										);
										wp_nav_menu($args);
										?>
									</li>
								<?php endif; ?>
								<li class="divider-vertical"></li>
								<li>
									<?php get_search_form(); ?>
								</li>
								<li>
									<a href="<?php echo esc_url(home_url('?feed=rss2')); ?>">
										<img src="<?php bloginfo('stylesheet_directory'); ?>/img/rss.png" title="<?php _e('Subscribe to the RSS feed', 'shprinkone') ?>" alt="rss feed"/>
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
					$('#sidebar .widget ul').addClass('nav nav-tabs nav-stacked');
					
					$('footer .widget ul').addClass('nav nav-pills nav-stacked');

					$('footer .widget_recent_comments ul').removeClass('nav nav-pills nav-stacked');
				});
			</script>
		</header>