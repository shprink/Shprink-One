<?php
/**
 * Template file used to render the sidebar.
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>

<!-- TOP AREA -->
<?php if (has_nav_menu('sidebar-menu-top')): ?>
<?php
wp_nav_menu(array(
'theme_location' => 'sidebar-menu-top',
'menu_class' => 'nav nav-pills nav-stacked',
'walker' => new Bootstrap_Walker_Nav_Menu(),
'depth' => 3,
'items_wrap' => '<h4>' . shprinkone_get_menu_title('sidebar-menu-top') . '</h4><ul id="%1$s" class="%2$s">%3$s</ul>'));
?>
<?php endif; ?>
<?php if (is_active_sidebar('sidebar-widget-top')) : ?>
<?php dynamic_sidebar('sidebar-widget-top'); ?>
<?php endif; ?>
<!-- MIDDLE AREA -->
<?php if (has_nav_menu('sidebar-menu-middle')): ?>
<?php
wp_nav_menu(array(
'theme_location' => 'sidebar-menu-middle',
'menu_class' => 'nav nav-pills nav-stacked',
'walker' => new Bootstrap_Walker_Nav_Menu(),
'depth' => 3,
'items_wrap' => '<h4>' . shprinkone_get_menu_title('sidebar-menu-middle') . '</h4><ul id="%1$s" class="%2$s">%3$s</ul>'));
?>
<?php endif; ?>
<?php if (is_active_sidebar('sidebar-widget-middle')) : ?>
<?php dynamic_sidebar('sidebar-widget-middle'); ?>
<?php endif; ?>
<!-- BOTTOM AREA -->
<?php if (has_nav_menu('sidebar-menu-bottom')): ?>
<?php
wp_nav_menu(array(
'theme_location' => 'sidebar-menu-bottom',
'menu_class' => 'nav nav-pills nav-stacked',
'walker' => new Bootstrap_Walker_Nav_Menu(),
'depth' => 3,
'items_wrap' => '<h4>' . shprinkone_get_menu_title('sidebar-menu-bottom') . '</h4><ul id="%1$s" class="%2$s">%3$s</ul>'));
?><?php endif; ?>
<?php if (is_active_sidebar('sidebar-widget-bottom')) : ?>
<?php dynamic_sidebar('sidebar-widget-bottom'); ?>
<?php endif; ?>