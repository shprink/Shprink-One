<?php
/**
 * This file basically acts like a plugin, and if it is present in the theme you are using,
 * it is automatically loaded during WordPress initialization (both for admin pages and external pages).
 *
 * @subpackage  shprink_one
 * @since       1.0
 */
require( get_template_directory() . '/admin/functions.php' );

include_once( 'functions/Widget/RecentPosts.php' );
include_once( 'functions/Widget/TagCloud.php' );
include_once( 'functions/Widget/NavMenu.php' );
include_once( 'functions/Widget/Archives.php' );
include_once( 'functions/Widget/Calendar.php' );
include_once( 'functions/Widget/Categories.php' );
include_once( 'functions/Widget/Links.php' );
include_once( 'functions/Widget/Meta.php' );
include_once( 'functions/Widget/Pages.php' );
include_once( 'functions/Widget/RSS.php' );
include_once( 'functions/Widget/RecentComments.php' );
include_once( 'functions/Widget/Search.php' );
include_once( 'functions/Widget/Text.php' );

// include Walker overwrite
include_once( 'functions/Walker/NavMenu.php' );
include_once( 'functions/Walker/Comment.php' );

function shprinkone_tag_cloud_widgets_init()
{
    unregister_widget('WP_Widget_Tag_Cloud');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Nav_Menu_Widget');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Text');

    register_widget('Shprinkone_Widget_Tag_Cloud');
    register_widget('Shprinkone_Widget_Recent_Posts');
    register_widget('Shprinkone_Widget_Nav_Menu');
    register_widget('Shprinkone_Widget_Archives');
    register_widget('Shprinkone_Widget_Calendar');
    register_widget('Shprinkone_Widget_Categories');
    register_widget('Shprinkone_Widget_Links');
    register_widget('Shprinkone_Widget_Meta');
    register_widget('Shprinkone_Widget_Pages');
    register_widget('Shprinkone_Widget_RSS');
    register_widget('Shprinkone_Widget_Recent_Comments');
    register_widget('Shprinkone_Widget_Search');
    register_widget('Shprinkone_Widget_Text');

    add_filter('widget_tag_cloud_args', 'shprinkone_widget_tag_cloud_args');
    add_filter('wp_generate_tag_cloud', 'shprinkone_wp_generate_tag_cloud', 10, 3);
}
add_action('widgets_init', 'shprinkone_tag_cloud_widgets_init');

function shprinkone_enqueue_script_and_style() {
	$directory_uri = get_template_directory_uri();
	$js_path = $directory_uri . '/js/';
	$selectedTemplate = shprinkone_get_selected_template();

	wp_register_script('bootstrap', $js_path . 'bootstrap.min.js');
	wp_register_script('infinitescroll', $js_path . 'jquery.infinitescroll.min.js');
	wp_register_script('sidr', $js_path . 'jquery.sidr.min.js');

	// Customize theme via URL
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

	wp_enqueue_style('shprinkone-theme', $directory_uri . $selectedTemplate['path'], array(), '2013-10-08');
	wp_enqueue_style('shprinkone-style', get_stylesheet_uri(), array(), '2013-10-08');

	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap');
	wp_enqueue_script('infinitescroll');
	wp_enqueue_script('sidr');
	wp_enqueue_script('jquery-masonry');
}

add_action('wp_enqueue_scripts', 'shprinkone_enqueue_script_and_style');

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width))
	$content_width = 940;

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since   Shprinkone 2.0.0
 *
 * @param   string  $title Default title text for current view.
 * @param   string  $sep Optional separator.
 *
 * @return  string  The filtered title.
 */
function twentythirteen_wp_title($title, $sep) {
	global $paged, $page;

	if (is_feed())
		return $title;

	// Add the site name.
	$title .= get_bloginfo('name');

	// Add the site description for the home/front page.
	$site_description = get_bloginfo('description', 'display');
	if ($site_description && ( is_home() || is_front_page() ))
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ($paged >= 2 || $page >= 2)
		$title = "$title $sep " . sprintf(__('Page %s', 'shprinkone'), max($paged, $page));

	return $title;
}

add_filter('wp_title', 'twentythirteen_wp_title', 10, 2);

/**
 * Add the selected CSS to the TinyMCE visual editor
 *
 * @return  void
 * @since   1.0.2
 */
function shprinkone_add_editor_styles() {
	$selectedTemplate = shprinkone_get_selected_template();
	add_editor_style($selectedTemplate['path']);
}

add_action('init', 'shprinkone_add_editor_styles');

/**
 * Get the selected template meta data
 *
 * @return  array  selected template meta data
 * @since   1.0.2
 */
function shprinkone_get_selected_template() {
	$option_template = shprinkone_get_theme_option('theme_template');
	$templates = shprinkone_get_theme_templates();
	return $templates[$option_template];
}

/**
 * Get a specific option
 *
 * @return  string  css
 * @since   2.3.2
 */
function shprinkone_get_theme_option($key = '') {
	$options = shprinkone_get_theme_options();
	return $options[$key];
}

/**
 * Inject custom CSS
 *
 * @return  void
 * @since   2.1.0
 */
function shprinkone_inject_custom_css()
{
    ?>
         <style type="text/css">
            <?php echo shprinkone_get_theme_option('theme_css'); ?>
         </style>
    <?php
}
add_action( 'wp_head', 'shprinkone_inject_custom_css');

/**
 * Register widget location within the template
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_widgets_init() {
	register_sidebar(
			array(
				'name' => __('Sidebar Widget Top', 'shprinkone'),
				'id' => 'sidebar-widget-top',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => "</div>\n",
				'description' => __('Sidebar Widget Top', 'shprinkone'),
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			)
	);
	register_sidebar(
			array(
				'name' => __('Sidebar Widget Middle', 'shprinkone'),
				'id' => 'sidebar-widget-middle',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => "</div>\n",
				'description' => __('Sidebar Widget Middle', 'shprinkone'),
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			)
	);
	register_sidebar(
			array(
				'name' => __('Sidebar Widget Bottom', 'shprinkone'),
				'id' => 'sidebar-widget-bottom',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => "</div>\n",
				'description' => __('Sidebar Widget Bottom', 'shprinkone'),
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			)
	);
	register_sidebar(
			array(
				'name' => __('Footer Widget Left', 'shprinkone'),
				'id' => 'footer-widget-left',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => "</div>\n",
				'description' => __('Footer Widget Left', 'shprinkone'),
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			)
	);
	register_sidebar(
			array(
				'name' => __('Footer Widget Middle Left', 'shprinkone'),
				'id' => 'footer-widget-middle-left',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => "</div>\n",
				'description' => __('Footer Widget Middle Left', 'shprinkone'),
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			)
	);
	register_sidebar(
			array(
				'name' => __('Footer Widget Middle Right', 'shprinkone'),
				'id' => 'footer-widget-middle-right',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => "</div>\n",
				'description' => __('Footer Widget Middle Right', 'shprinkone'),
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			)
	);
	register_sidebar(
			array(
				'name' => __('Footer Widget Right', 'shprinkone'),
				'id' => 'footer-widget-right',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => "</div>\n",
				'description' => __('Footer Widget Right', 'shprinkone'),
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			)
	);
	register_sidebar(
			array(
				'name' => __('Footer Widget Bottom', 'shprinkone'),
				'id' => 'footer-widget-bottom',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => "</div>\n",
				'description' => __('Footer Widget Bottom', 'shprinkone'),
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			)
	);
	register_sidebar(
			array(
				'name' => __('Before Content', 'shprinkone'),
				'id' => 'before-content-widget',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => "</div>\n",
				'description' => __('Before Content', 'shprinkone'),
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			)
	);
	register_sidebar(
			array(
				'name' => __('After Content', 'shprinkone'),
				'id' => 'after-content-widget',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => "</div>\n",
				'description' => __('After Content', 'shprinkone'),
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			)
	);
}

add_action('widgets_init', 'shprinkone_widgets_init');

/**
 * Register menus location within the template
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_menus_init() {
	register_nav_menus(
			array(
				'primary' => __('Menu Top', 'shprinkone'),
				'sidebar-menu-top' => __('Sidebar Menu Top', 'shprinkone'),
				'sidebar-menu-middle' => __('Sidebar Menu Middle', 'shprinkone'),
				'sidebar-menu-bottom' => __('Sidebar Menu Bottom', 'shprinkone')
			)
	);
}

add_action('init', 'shprinkone_menus_init');

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_setup(){

    // Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
    // TODO
    // add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'quote', 'status', 'video' ) );
    // This theme uses post thumbnails
    add_theme_support('post-thumbnails');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Image size
    add_image_size('post-image-mansory', 268, 268, true);
    add_image_size('post-image-width9', 860, 200, true);
    add_image_size('post-image-width12', 1170, 200, true);

    // Translation
    load_theme_textdomain('shprinkone', get_template_directory() . '/lang');
}
add_action('after_setup_theme', 'shprinkone_setup');

		/**
		 * Get Calendar for masonry items
		 *
		 * @return  void
		 * @since   1.0
		 */
		function shprinkone_get_calendar() {
			$format = '<div class="calendar-outer btn-inverse"><div class="calendar-inner"><div class="calendar-date"><i class="icon-calendar icon-white"></i> %s</div></div></div>';
			$arg = get_the_date(__('M d, Y', 'shprinkone'));
			printf($format, $arg);
		}

		/**
		 * Get the author post link
		 *
		 * @return  string
		 * @since   1.0
		 */
		function shprinkone_get_the_author_posts_link() {
			$format = '<a href="%1$s" title="%2$s" rel="author">%3$s</a>';
			$link = sprintf($format, get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('nicename')), esc_attr(sprintf(__('Posts by %s', 'shprinkone'), get_the_author())), get_the_author());

			return sprintf(__('By: %s', 'shprinkone'), $link);
		}

		/**
		 * Get the comment number
		 *
		 * @return  string
		 * @since   1.0
		 */
		function shprinkone_get_comments_number() {
			$number = get_comments_number();
			if ($number > 1) {
				return sprintf(__('%d Comments', 'shprinkone'), $number);
			} else {
				return sprintf(__('%d Comment', 'shprinkone'), $number);
			}
		}

		/**
		 * Get post meta(date, categories, tags etc.)
		 *
		 * @param   boolean  $inline
		 * @param   boolean  $author
		 * @param   boolean  $date
		 * @param   boolean  $category
		 * @param   boolean  $tag
		 * @param   boolean  $comments
		 * @param   boolean  $sticky
		 * @param   boolean  $tooltip
		 * @return  string
		 * @since   1.0
		 */
		function shprinkone_get_post_meta($inline = false, $author = true, $date = false, $category = true, $tag = true, $comments = false, $sticky = false, $tooltip = false) {
			$inline = ($inline) ? 'list-inline' : 'list-unstyled';
			$html = '<div class = "post-meta">';
			$html .= '<ul class = "' . $inline . '">';
			if (is_sticky() && $sticky) {
				$html .= '<li class = "post-sticky label label-info" ';
				$html .= ($tooltip) ? 'data-content="' . __('Featured', 'shprinkone') . '"' : '';
				$html .= '><i class = "icon-star"></i> ';
				$html .= ($tooltip) ? '' : __('Featured', 'shprinkone');
				$html .= '</li>';
			}
			if ($date) {
				$formatedDate = get_the_date(__('M d, Y', 'shprinkone'));
				$html .= '<li class = "post-date" ';
				$html .= ($tooltip) ? 'title="' . __('Published on', 'shprinkone') . '" data-content="' . $formatedDate . '"' : '';
				$html .= '><i class = "icon-calendar"></i> ';
				$html .= ($tooltip) ? '' : $formatedDate;
				$html .= '</li>';
			}
			if ($author) {
				$authorName = get_the_author();
				$html .= '<li class = "post-author" ';
				$html .= ($tooltip) ? 'title="' . __('Author', 'shprinkone') . '" data-content="' . $authorName . '"' : '';
				$html .= '><i class = "icon-user"></i> ';
				$html .= ($tooltip) ? '' : shprinkone_get_the_author_posts_link();
				$html .= '</li>';
			}
			if ($category) {
				if (has_category()):
					$categories = get_the_category();
					$categoryList = array();
					foreach ($categories as $category) {
						$categoryList[] = $category->cat_name;
					}
					$html .= '<li class = "post-category" ';
					$html .= ($tooltip) ? 'title="' . __('Categories', 'shprinkone') . '" data-content="' . join(", ", $categoryList) . '"' : '';
					$html .= '><i class = "icon-folder-open"></i> ';
					$html .= ($tooltip) ? '' : sprintf(__('Category: %s', 'shprinkone'), get_the_category_list(' ', '', false));
					$html .= '</li>';
				endif;
			}
			if ($tag) {
				if (has_tag()):
					$tags = get_the_tags();
					$tagList = array();
					foreach ($tags as $tag) {
						$tagList[] = $tag->name;
					}
					$html .= '<li class = "post-tags" ';
					$html .= ($tooltip) ? 'title="' . __('Tags', 'shprinkone') . '" data-content="' . join(", ", $tagList) . '"' : '';
					$html .= '><i class = "icon-tags"></i> ';
					$html .= ($tooltip) ? '' : get_the_tag_list(__('Tag:  ', 'shprinkone'), ' ');
					$html .= '</li>';
				endif;
			}
			if ($comments) {
				$commentNumber = get_comments_number();
				$html .= '<li class = "post-comments" ';
				$html .= ($tooltip) ? 'title="' . __('Comments', 'shprinkone') . '" data-content="' . $commentNumber . '"' : '';
				$html .= '><i class = "icon-comment"></i> ';
				$html .= $commentNumber;
				$html .= '</li>';
			}
			$html .= '</ul>';
			$html .= '</div>';
			return $html;
		}

		/**
		 * Get menu title
		 *
		 * @return  string
		 * @since   1.0
		 */
		function shprinkone_get_menu_title($theme_location) {

			$locations = (array) get_nav_menu_locations();

			$menu = wp_get_nav_menu_object($locations[$theme_location]);

			return $menu->name;
		}

		/**
		 * Display sidebar
		 *
		 * @return  void
		 * @since   1.0
		 */
		function shprinkone_get_sidebar($side) {
			$options = shprinkone_get_theme_options();
			$layout = $options['theme_layout'];
			$condition1 = ($side == 'left' && $layout == 'sidebar-content');
			$condition2 = ($side == 'right' && $layout == 'content-sidebar');
			if ($condition1 || $condition2) {
				echo '<div id="sidebar" class="col-sm-3 col-md-3 col-lg-3"><div class="sidebar-inner">';
				get_sidebar();
				echo '</div></div>';
			}
		}

		/**
		 * Is sidebar active
		 *
		 * @return  string
		 * @since   1.0
		 */
		function shprinkone_is_sidebar_active() {
			$bool = has_nav_menu('sidebar-menu-top') ||
					is_active_sidebar('sidebar-widget-top') ||
					has_nav_menu('sidebar-menu-middle') ||
					is_active_sidebar('sidebar-widget-middle') ||
					has_nav_menu('sidebar-menu-bottom') ||
					is_active_sidebar('sidebar-widget-bottom');
			return $bool;
		}

		/**
		 * Get the columns width
		 *
		 * @return  string
		 * @since   1.0
		 */
		function shprinkone_get_contentspan() {
			if (!shprinkone_is_sidebar_active()) {
				return 'col-sm-12 col-md-12 col-lg-12';
			}
			$options = shprinkone_get_theme_options();
			return ($options['theme_layout'] == 'content') ? 'col-sm-12 col-md-12 col-lg-12' : 'col-sm-9 col-md-9 col-lg-9';
		}

		/**
		 * Get the image width
		 *
		 * @return  string
		 * @since   1.0
		 */
		function shprinkone_get_imagespan() {
			if (!shprinkone_is_sidebar_active()) {
				return 'width12';
			}
			$options = shprinkone_get_theme_options();
			return ($options['theme_layout'] == 'content') ? 'width12' : 'width9';
		}

		/**
		 * Get the no result string
		 *
		 * @return  string
		 * @since   1.0
		 */
		function shprinkone_get_no_result() {
			$span = shprinkone_get_contentspan();
			$html = '<section class="no-result ' . $span . '">';
			$html .= '<p>' . __('Sorry, no posts matched your criteria.', 'shprinkone') . '</p>';
			$html .= '</section>';
			return $html;
		}

		/**
		 * Outputs a complete commenting form for use within a template.
		 *
		 * @since  1.0
		 * @param  array $args Options for strings, fields etc in the form
		 * @param  mixed $post_id Post ID to generate the form for, uses the current post if null
		 * @return void
		 */
		function shprinkone_comment_form($args = array(), $post_id = null) {
			global $id;

			if (null === $post_id) {
				$post_id = $id;
			} else {
				$id = $post_id;
			}

			$commenter = wp_get_current_commenter();

			$user = wp_get_current_user();

			$user_identity = $user->exists() ? $user->display_name : '';

			$req = get_option('require_name_email');

			$aria_req = $req ? " aria-required='true'" : '';

			$fields = array(
				'author' => '<p class="comment-form-author"><label for="author">' . __('Name', 'shprinkone') . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="author" name="author" class="form-control" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
				'email' => '<p class="comment-form-email"><label for="email">' . __('Email', 'shprinkone') . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="email" name="email" class="form-control" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
				'url' => '<p class="comment-form-url"><label for="url">' . __('Website', 'shprinkone') . '</label><input id="url" name="url" class="form-control" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>',
			);

			$required_text = sprintf(' ' . __('Required fields are marked %s', 'shprinkone'), '<span class="required">*</span>');
			$defaults = array(
				'fields' => apply_filters('comment_form_default_fields', $fields),
				'comment_field' => '<p class="comment-form-comment"><label for="comment">' . __('Comment', 'shprinkone') . '</label><textarea id="comment" name="comment" class="form-control" aria-required="true"></textarea></p>',
				'must_log_in' => '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.', 'shprinkone'), wp_login_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
				'logged_in_as' => '<p class="logged-in-as">' . sprintf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'shprinkone'), get_edit_user_link(), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
				'comment_notes_before' => '<p class="comment-notes">' . __('Your email address will not be published.', 'shprinkone') . ( $req ? $required_text : '' ) . '</p>',
				'comment_notes_after' => null,
				'id_form' => 'commentform',
				'id_submit' => 'submit',
				'title_reply' => __('Leave a Reply', 'shprinkone'),
				'title_reply_to' => __('Leave a Reply to %s', 'shprinkone'),
				'cancel_reply_link' => __('Cancel reply', 'shprinkone'),
				'label_submit' => __('Post Comment', 'shprinkone'),
			);

			$args = wp_parse_args($args, apply_filters('comment_form_defaults', $defaults));
			?>
			<?php if (comments_open($post_id)) : ?>
				<?php do_action('comment_form_before'); ?>
				<div id="respond">
					<?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
						<?php echo $args['must_log_in']; ?>
						<?php do_action('comment_form_must_log_in_after'); ?>
					<?php else : ?>
						<form action="<?php echo site_url('/wp-comments-post.php'); ?>"
							  method="post" id="<?php echo esc_attr($args['id_form']); ?>">
							<fieldset>
								<legend id="reply-title">
									<?php comment_form_title($args['title_reply'], $args['title_reply_to']); ?>
									<small><?php cancel_comment_reply_link($args['cancel_reply_link']); ?>
									</small>
								</legend>

								<?php do_action('comment_form_top'); ?>
								<?php if (is_user_logged_in()) : ?>
									<?php echo apply_filters('comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity); ?>
									<?php do_action('comment_form_logged_in_after', $commenter, $user_identity); ?>
								<?php else : ?>
									<?php echo $args['comment_notes_before']; ?>
									<?php
									do_action('comment_form_before_fields');
									foreach ((array) $args['fields'] as $name => $field) {
										echo apply_filters("comment_form_field_{$name}", $field) . "\n";
									}
									do_action('comment_form_after_fields');
									?>
								<?php endif; ?>
								<?php echo apply_filters('comment_form_field_comment', $args['comment_field']); ?>
								<?php echo $args['comment_notes_after']; ?>
								<p class="form-submit">
									<button class="btn btn-default btn-block" name="submit" type="submit"
											id="<?php echo esc_attr($args['id_submit']); ?>">
												<?php echo esc_attr($args['label_submit']); ?>
									</button>
									<?php comment_id_fields($post_id); ?>
								</p>
								<?php do_action('comment_form', $post_id); ?>
							</fieldset>
						</form>
					<?php endif; ?>
				</div>
				<!-- #respond -->
				<?php do_action('comment_form_after'); ?>
			<?php else : ?>
				<?php do_action('comment_form_comments_closed'); ?>
			<?php endif; ?>
			<?php
		}

		function shprinkone_link_pages($args = '') {
			$defaults = array(
				'before' => '<div class="text-center"><ul class="pagination">',
				'after' => '</ul></div>',
				'link_before' => '',
				'link_after' => '',
				'next_or_number' => 'number',
				'nextpagelink' => __('Next page', 'shprinkone'),
				'previouspagelink' => __('Previous page', 'shprinkone'), 'pagelink' => '%',
				'echo' => 1,
			);

			$r = wp_parse_args($args, $defaults);
			$r = apply_filters('wp_link_pages_args', $r);
			extract($r, EXTR_SKIP);

			global $page, $numpages, $multipage, $more, $pagenow;

			$output = '';
			if ($multipage) {
				if ('number' == $next_or_number) {
					$output .= $before;
					for ($i = 1; $i < ($numpages + 1); $i = $i + 1) {
						$j = str_replace('%', $i, $pagelink);
						if (($i != $page) || ((!$more) && ($page == 1))) {
							$output .= ' <li>';
							$output .= _wp_link_page($i);
						} else {
							$output .= ' <li class="active">';
							$output .= '<a href="#">';
						}
						$output .= $link_before . $j . $link_after;
						$output .= '</a></li>';
					}
					$output .= $after;
				} else {
					if ($more) {
						$output .= $before;
						$i = $page - 1;
						if ($i && $more) {
							$output .= '<li>' . _wp_link_page($i);
							$output .= $link_before . $previouspagelink . $link_after . '</a></li>';
						}
						$i = $page + 1;
						if ($i <= $numpages && $more) {
							$output .= '<li>' . _wp_link_page($i);
							$output .= $link_before . $nextpagelink . $link_after . '</a></li>';
						}
						$output .= $after;
					}
				}
			}

			if ($echo) {
				echo $output;
			}

			return $output;
		}
