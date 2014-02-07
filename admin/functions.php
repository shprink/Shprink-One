<?php

/**
 * ADMINISTRATION
 */
function shprinkone_enqueue_admin_script_and_style() {
	$directory_uri = get_template_directory_uri();
	$js_path = $directory_uri . '/js/';
	$css_path = $directory_uri . '/css/';
	wp_register_style('jquery-toggles', $css_path . 'toggles.css', false, '1.0.0');
	wp_register_style('custom_wp_admin_css', $css_path . 'admin-style.css', false, '1.0.0');
	wp_enqueue_style('jquery-toggles');
	wp_enqueue_style('custom_wp_admin_css');

	wp_register_script('custom_wp_admin_js', $js_path . 'admin-script.js');
	wp_register_script('jquery-toggles', $js_path . 'toggles.min.js');
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-toggles');
	wp_enqueue_script('custom_wp_admin_js');
}

add_action('admin_enqueue_scripts', 'shprinkone_enqueue_admin_script_and_style');

/**
 * Register widget location within the template
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_theme_options_init() {
	register_setting(
			'shprinkone_options', 'shprinkone_theme_options', 'shprinkone_theme_options_validate'
	);
	// Register our settings field group
	add_settings_section(
			'general', __('General', 'shprinkone'), '__return_false', 'theme_options'
	);
	add_settings_section(
			'homepage', __('Homepage', 'shprinkone'), '__return_false', 'theme_options'
	);
	add_settings_section(
			'style', __('CSS and Layout', 'shprinkone'), '__return_false', 'theme_options'
	);

	add_settings_field('header', __('Header', 'shprinkone'), 'shprinkone_settings_field_header', 'theme_options', 'general');
	add_settings_field('slideshow', __('Slideshow', 'shprinkone'), 'shprinkone_settings_field_slideshow', 'theme_options', 'homepage');
	add_settings_field('posts', __('Post layout on blog, category, tag and author page.', 'shprinkone'), 'shprinkone_settings_field_posts', 'theme_options', 'homepage');
	add_settings_field('fluidity', __('Fluidity', 'shprinkone'), 'shprinkone_settings_field_fluidity', 'theme_options', 'style');
	add_settings_field('layout', __('Layout', 'shprinkone'), 'shprinkone_settings_field_layout', 'theme_options', 'style');
	add_settings_field('template', __('Theme', 'shprinkone'), 'shprinkone_settings_field_template', 'theme_options', 'style');
	add_settings_field('css', __('Css overwrite', 'shprinkone'), 'shprinkone_settings_field_css', 'theme_options', 'style');
}

add_action('admin_init', 'shprinkone_theme_options_init');

/**
 * Add theme admin page
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_add_theme_page() {
	$theme_page = add_theme_page(
			__('Theme Options', 'shprinkone'), // Name of page
			__('Theme Options', 'shprinkone'), // Label in menu
			'edit_theme_options', // Capability required
			'theme_options', // Menu slug, used to uniquely identify the page
			'shprinkone_theme_options_render' // Function that renders the options page
	);

	if (!$theme_page)
		return;
}

add_action('admin_menu', 'shprinkone_add_theme_page');

/**
 * Render options
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_theme_options_render() {
	$theme_name = wp_get_theme();
	echo '<div class="wrap has-right-sidebar">';
	screen_icon();
	echo '<h2>' . sprintf(__('%s Theme Options', 'shprinkone'), $theme_name) . '</h2>';
	settings_errors();

	echo '<div id="side-info-column" class="inner-sidebar">';
	echo '<div class="postbox">';
	echo '<h3>ShprinkOne ' . $theme_name->get('Version') . '</h3>';
	echo '<div class="inside">';
	echo '<p>Author : Julien Renaux</p>';
	echo '<p>Email : <a href="mailto:contact@julienrenaux.fr" target="_blank">contact@julienrenaux.fr</a></p>';
	echo '<p>Blog : <a href="http://julienrenaux.fr/" target="_blank">julienrenaux.fr</a></p>';
	echo '<h4>' . __('Keep in touch with ShprinkOne updates!', 'shprinkone') . '</h4>';
	echo '<iframe src="http://ghbtns.com/github-btn.html?user=shprink&repo=Shprink-One&type=watch&count=true"
  allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>';
	echo '<p>Twitter : <a href="http://twitter.com/julienrenaux" target="_blank">@julienrenaux</a></p>';
	echo '<p>Facebook : <a href="https://www.facebook.com/julienrenauxblog" target="_blank">julienrenauxblog</a></p>';
	echo '</div>';
	echo '</div>';

	echo'</div>';

	echo '<div id="post-body">';
	echo '<div id="post-body-content">';
	echo '<form method="post" action="options.php">';
	settings_fields('shprinkone_options');
	do_settings_sections('theme_options');
	submit_button();
	echo'</form>';
	echo'</div>';
	echo'</div>';
	echo'</div>';
}

/**
 * Set fluidity layout
 *
 * @return  void
 * @since   2.2.0
 */
function shprinkone_settings_field_fluidity() {
	$options = shprinkone_get_theme_options();
	if (!isset($options['theme_fluidity'])) {
		return;
	}
	$theme_fluidity = $options['theme_fluidity'];
	$checked = (isset($theme_fluidity['front']) && $theme_fluidity['front'] == true) ? 'checked="checked"' : '';
	echo '<input id="fluidity_front" type="checkbox" name="shprinkone_theme_options[theme_fluidity][front]" ' . $checked . '>';
	echo '<label for="fluidity_front"> ' . __('Front page', 'shprinkone') . '</label> ';
	echo '<br/>';
	$checked = (isset($theme_fluidity['post']) && $theme_fluidity['post'] == true) ? 'checked="checked"' : '';
	echo '<input id="fluidity_post" type="checkbox" name="shprinkone_theme_options[theme_fluidity][post]" ' . $checked . '>';
	echo '<label for="fluidity_post"> ' . __('Single post', 'shprinkone') . '</label> ';
	echo '<br/>';
	$checked = (isset($theme_fluidity['page']) && $theme_fluidity['page'] == true) ? 'checked="checked"' : '';
	echo '<input id="fluidity_page" type="checkbox" name="shprinkone_theme_options[theme_fluidity][page]" ' . $checked . '>';
	echo '<label for="fluidity_page"> ' . __('Page', 'shprinkone') . '</label> ';
}

/**
 * Set field layout
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_settings_field_layout() {
	$options = shprinkone_get_theme_options();
	if (!isset($options['theme_layout'])) {
		return;
	}
	echo '<table class="widefat">';
	echo '<thead><tr>';
	echo '<th style="width:10px;"></th>';
	echo '<th>' . __('Thumbnail', 'shprinkone') . '</th>';
	echo '<th>' . __('Position', 'shprinkone') . '</th>';
	echo '</tr></thead>';
	echo '<tbody>';

	$i = 0;
	foreach (shprinkone_get_theme_layouts() as $key => $layout) {
		$checked = ($options['theme_layout'] == $key) ? 'checked="checked"' : '';
		echo ($i % 2 == 0) ? '<tr>' : '<tr class="alternate">';
		echo '<td><input type="radio" name="shprinkone_theme_options[theme_layout]" value="' . $layout['value'] . '" ' . $checked . '></td>';
		echo '<td><img src="' . esc_url($layout['thumbnail']) . '" width="80" height="80" alt="" /></td>';
		echo '<td>' . $layout['label'] . '</td>';
		echo '</tr>';
		$i++;
	}
	echo '<tbody>';
	echo '</table>';
}

/**
 * Set field layout
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_settings_field_header() {
	$options = shprinkone_get_theme_options();
	if (!isset($options['theme_header'])) {
		$options = shprinkone_get_theme_default();
	}
	$posts_option = $options['theme_header'];

	$checked = (isset($posts_option['rss']) && $posts_option['rss'] == true) ? 'checked="checked"' : '';
	echo '<input id="theme_header_rss" type="checkbox" name="shprinkone_theme_options[theme_header][rss]" ' . $checked . '>';
	echo '<label for="theme_header_rss"> ' . __('Display RSS', 'shprinkone') . '</label> ';
	$checked = (isset($posts_option['search']) && $posts_option['search'] == true) ? 'checked="checked"' : '';
	echo '<br/><input id="theme_header_search" type="checkbox" name="shprinkone_theme_options[theme_header][search]" ' . $checked . '>';
	echo '<label for="theme_header_search"> ' . __('Display search box', 'shprinkone') . '</label> ';
	$checked = (isset($posts_option['icon-home']) && $posts_option['icon-home'] == true) ? 'checked="checked"' : '';
	echo '<br/><input id="theme_header_icon-home" type="checkbox" name="shprinkone_theme_options[theme_header][icon-home]" ' . $checked . '>';
	echo '<label for="theme_header_icon-home"> ' . __('Display home icon', 'shprinkone') . '</label> ';
}

/**
 * Set field template
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_settings_field_template() {
	$options = shprinkone_get_theme_options();
	if (!isset($options['theme_template'])) {
		return;
	}
	echo '<fieldset id="color-picker" class="scheme-list">';
	$i = 0;
	foreach (shprinkone_get_theme_templates() as $key => $template) {
		$checked = ($options['theme_template'] == $key) ? 'checked="checked"' : '';
		$selected = ($options['theme_template'] == $key) ? 'selected' : '';
		echo '<div class="color-option ' . $selected . '">';
		echo '<input class="tog" type="radio" name="shprinkone_theme_options[theme_template]" value="' . $template['value'] . '" ' . $checked . '>';
		echo '<label>' . $template['name'] . '</label>';
		echo shprinkone_format_template_colors($template['colors']);
		echo '</div>';
		$i++;
	}
	echo '</fieldset>';
	echo '<span class="description alignright">Themes by <a href="http://bootswatch.com" target="_blank">Bootswatch</a></span>';
}

/**
 * Set CSS filed
 *
 * @return  void
 * @since   2.1.0
 */
function shprinkone_settings_field_css() {
	$options = shprinkone_get_theme_options();
	if (!isset($options['theme_css'])) {
		return;
	}
	echo '<textarea name="shprinkone_theme_options[theme_css]" rows="20" style="width: 100%;">' . $options['theme_css'] . '</textarea>';
}

/**
 * Set posts loop
 *
 * @return  void
 * @since   2.0
 */
function shprinkone_settings_field_posts() {
	$options = shprinkone_get_theme_options();
	if (!isset($options['theme_posts'])) {
		$options = shprinkone_get_theme_default();
	}
	$posts_option = $options['theme_posts'];
	echo '<label for="posts_type"> ' . __('Posts loading type', 'shprinkone') . '</label> ';
	echo '<select id="posts_type" name="shprinkone_theme_options[theme_posts][type]" value="' . $posts_option['type'] . '">';
	foreach (shprinkone_get_theme_posts() as $value => $title) {
		$selected = ($posts_option['type'] === $value) ? 'selected="selected"' : '';
		echo '<option value="' . $value . '" ' . $selected . '>' . $title . '</option>';
	}
	echo '</select><br/>';
	$checked = (isset($posts_option['meta']) && $posts_option['meta']) ? 'checked="checked"' : '';
	echo '<input id="posts_meta" type="checkbox" name="shprinkone_theme_options[theme_posts][meta]" ' . $checked . '>';
	echo ' <label for="posts_meta"> ' . __('Adding meta on each post', 'shprinkone') . '</label> ';
}

/**
 * Set field slideshow
 *
 * @return  void
 * @since   1.0.5
 */
function shprinkone_settings_field_slideshow() {
	$options = shprinkone_get_theme_options();
	if (!isset($options['theme_slideshow'])) {
		return;
	}
	$slideshow_option = $options['theme_slideshow'];
	echo '<label for="slideshow_posts">' . __('Number of post', 'shprinkone') . '</label> ';
	echo '<select id="slideshow_posts" name="shprinkone_theme_options[theme_slideshow][posts]" value="' . $slideshow_option['posts'] . '">';
	echo '<label for="slideshow_posts">' . __('Number of post', 'shprinkone') . '</label> ';
	for ($index = 0; $index <= 5; $index++) {
		$selected = ((int) $slideshow_option['posts'] === $index) ? 'selected="selected"' : '';
		echo '<option value="' . $index . '" ' . $selected . '>' . $index . '</option>';
	}
	echo '</select><br/>';
	$checked = (isset($slideshow_option['copy_within_content']) && $slideshow_option['copy_within_content']) ? 'checked="checked"' : '';
	echo '<input id="slideshow_copy_within_content" type="checkbox" name="shprinkone_theme_options[theme_slideshow][copy_within_content]" ' . $checked . '>';
	echo ' <label for="slideshow_copy_within_content"> ' . __('Duplicate slideshow posts within the content', 'shprinkone') . '</label> ';
}

function shprinkone_format_template_colors($colors) {
	$html = '';
	if (!is_array($colors)) {
		return $html;
	}
	$html .= '<table class="color-palette"><tbody><tr>';
	foreach ($colors as $color) {
		$html .= '<td style="background-color:' . $color . ';">&nbsp;</td>';
	}
	$html .= '</tbody></tr></table>';
	return $html;
}

/**
 * Get theme options
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_get_theme_options() {
	if (get_option('shprinkone_theme_options')) {
		return array_merge(shprinkone_get_theme_default(), get_option('shprinkone_theme_options'));
	} else {
		return shprinkone_get_theme_default();
	}
}

/**
 * Get default theme options
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_get_theme_default() {
	$default_theme_options = array(
		'theme_layout' => 'content-sidebar',
		'theme_template' => 'flaty',
		'theme_css' => '/* INCLUDE YOUR CSS HERE */',
		'theme_posts' => array(
			'meta' => true,
			'type' => 'ajax_scroll'
		),
		'theme_slideshow' => array(
			'posts' => 3,
			'copy_within_content' => true
		),
		'theme_header' => array(
			'rss' => true,
			'search' => true,
			'icon-home' => true
		),
		'theme_fluidity' => array(
			'front' => false,
			'post' => false,
			'page' => false
		),
	);

	return apply_filters('shprinkone_default_theme_options', $default_theme_options);
}

/**
 * Set Layouts
 *
 * @return  mixed
 * @since   1.0
 */
function shprinkone_get_theme_layouts() {
	$layout_options = array();
	$layout_options['content-sidebar'] = array(
		'value' => 'content-sidebar',
		'label' => __('Content on left', 'shprinkone'),
		'thumbnail' => get_template_directory_uri() . '/img/content-sidebar.png',
	);
	$layout_options['sidebar-content'] = array(
		'value' => 'sidebar-content',
		'label' => __('Content on right', 'shprinkone'),
		'thumbnail' => get_template_directory_uri() . '/img/sidebar-content.png',
	);
	$layout_options['content'] = array(
		'value' => 'content',
		'label' => __('One-column, no sidebar', 'shprinkone'),
		'thumbnail' => get_template_directory_uri() . '/img/content.png',
	);
	return apply_filters('shprinkone_get_theme_layouts', $layout_options);
}

/**
 * Templates raw data
 *
 * @return  mixed
 * @since   1.0
 */
function shprinkone_get_theme_templates() {
	$templateList = array();
	$templateList['bootstrap'] = array(
		'name' => 'Bootstrap classic',
		'value' => 'bootstrap',
		'author' => 'http://twitter.github.com/bootstrap/',
		'path' => '/css/bootstrap.min.css',
		'colors' => array('#EEEEEE', '#FFFFFF', '#08c', '#333333'),
		'description' => __('Sleek, intuitive, and powerful front-end framework for faster and easier web development.', 'shprinkone')
	);
	$templateList['flaty'] = array(
		'name' => 'Flaty',
		'value' => 'flaty',
		'author' => 'http://bootswatch.com/',
		'path' => '/css/flaty.bootswatch.min.css',
		'colors' => array('#2C3E50', '#FFFFFF', '#1ABC9C', '#2C3E50'),
		'description' => __('Flat and clean.', 'shprinkone')
	);
	$templateList['cerulean'] = array(
		'name' => 'Cerulean',
		'value' => 'cerulean',
		'author' => 'http://bootswatch.com/',
		'path' => '/css/cerulean.bootswatch.min.css',
		'colors' => array('#2FA4E7', '#FFFFFF', '#2FA4E7', '#555555'),
		'description' => __('A calm, blue sky.', 'shprinkone')
	);
	$templateList['cosmo'] = array(
		'name' => 'Cosmo',
		'value' => 'cosmo',
		'author' => 'http://bootswatch.com/',
		'path' => '/css/cosmo.bootswatch.min.css',
		'colors' => array('#080808', '#FFFFFF', '#007FFF', '#555555'),
		'description' => __('An ode to Metro.', 'shprinkone')
	);
	$templateList['amelia'] = array(
		'name' => 'Amelia',
		'value' => 'amelia',
		'author' => 'http://bootswatch.com/',
		'path' => '/css/amelia.bootswatch.min.css',
		'colors' => array('#AD1D28', '#003F4D', '#DEBB27', '#FFFFFF'),
		'description' => __('Sweet and cheery.', 'shprinkone')
	);
	$templateList['readable'] = array(
		'name' => 'Readable',
		'value' => 'readable',
		'author' => 'http://bootswatch.com/',
		'path' => '/css/readable.bootswatch.min.css',
		'colors' => array('#F6F6F6', '#F6F6F6', '#E78B24', '#333333'),
		'description' => __('Optimized for legibility.', 'shprinkone')
	);
	$templateList['united'] = array(
		'name' => 'United',
		'value' => 'united',
		'author' => 'http://bootswatch.com/',
		'path' => '/css/united.bootswatch.min.css',
		'colors' => array('#DD4814', '#FFFFFF', '#DD4814', '#333333'),
		'description' => __('Ubuntu orange and unique font.', 'shprinkone')
	);
	$templateList['spacelab'] = array(
		'name' => 'Spacelab',
		'value' => 'spacelab',
		'author' => 'http://bootswatch.com/',
		'path' => '/css/spacelab.bootswatch.min.css',
		'colors' => array('#EEEEEE', '#FFFFFF', '#09d', '#666666'),
		'description' => __('Silvery and sleek.', 'shprinkone')
	);
	$templateList['simplex'] = array(
		'name' => 'Simplex',
		'value' => 'simplex',
		'author' => 'http://bootswatch.com/',
		'path' => '/css/simplex.bootswatch.min.css',
		'colors' => array('#fefefe', '#F7F7F7', '#D9230F', '#555555'),
		'description' => __('Mini and minimalist.', 'shprinkone')
	);
	$templateList['journal'] = array(
		'name' => 'Journal',
		'value' => 'journal',
		'author' => 'http://bootswatch.com/',
		'path' => '/css/journal.bootswatch.min.css',
		'colors' => array('#FFFFFF', '#FFFFFF', '#777777', '#777777'),
		'description' => __('Crisp like a new sheet of paper.', 'shprinkone')
	);
	$templateList['yeti'] = array(
		'name' => 'Yeti',
		'value' => 'yeti',
		'author' => 'http://bootswatch.com/',
		'path' => '/css/yeti.bootswatch.min.css',
		'colors' => array('#222222', '#FFFFFF', '#008cba', '#222222'),
		'description' => __('A friendly foundation.', 'shprinkone')
	);
	$templateList['custom'] = array(
		'name' => 'Custom (only for legacy purpose)',
		'value' => 'custom',
		'author' => 'none',
		'path' => '/css/custom.css',
		'colors' => array(),
		'description' => __('An empty CSS file that you can modify as you like.', 'shprinkone')
	);
	return apply_filters('shprinkone_get_theme_templates', $templateList);
}

/**
 * Set posts loop options
 *
 * @return  mixed
 * @since   1.0
 */
function shprinkone_get_theme_posts() {
	$posts_options = array(
		'ajax_scroll' => __('Ajax on scroll down', 'shprinkone'),
		'ajax_button' => __('Ajax on button clicked', 'shprinkone'),
		'default' => __('WordPress classic pagination', 'shprinkone')
	);
	return apply_filters('shprinkone_get_theme_posts', $posts_options);
}

/**
 * Validate theme options
 *
 * @return  mixed
 * @since   1.0
 */
function shprinkone_theme_options_validate($input) {
	$output = $defaults = shprinkone_get_theme_default();

	// Theme layout must be in our array of theme layout options
	if (isset($input['theme_layout']) && array_key_exists($input['theme_layout'], shprinkone_get_theme_layouts())) {
		$output['theme_layout'] = $input['theme_layout'];
	}

	if (isset($input['theme_css'])) {
		$output['theme_css'] = $input['theme_css'];
	}

	if (isset($input['theme_template']) && array_key_exists($input['theme_template'], shprinkone_get_theme_templates())) {
		$output['theme_template'] = $input['theme_template'];
	}

	if (isset($input['theme_slideshow'])) {
		$output['theme_slideshow'] = $input['theme_slideshow'];
	}
	$output['theme_slideshow']['copy_within_content'] = (isset($input['theme_slideshow']['copy_within_content'])) ? true : false;

	if (isset($input['theme_posts']['type']) && array_key_exists($input['theme_posts']['type'], shprinkone_get_theme_posts())) {
		$output['theme_posts']['type'] = $input['theme_posts']['type'];
	}
	$output['theme_posts']['meta'] = (isset($input['theme_posts']['meta'])) ? true : false;

	$output['theme_header']['rss'] = (isset($input['theme_header']['rss'])) ? true : false;
	$output['theme_header']['search'] = (isset($input['theme_header']['search'])) ? true : false;
	$output['theme_header']['icon-home'] = (isset($input['theme_header']['icon-home'])) ? true : false;

	if (isset($input['theme_fluidity'])) {
		$output['theme_fluidity'] = $input['theme_fluidity'];
	}
	$output['theme_fluidity']['front'] = (isset($input['theme_fluidity']['front'])) ? true : false;
	$output['theme_fluidity']['post'] = (isset($input['theme_fluidity']['post'])) ? true : false;
	$output['theme_fluidity']['page'] = (isset($input['theme_fluidity']['page'])) ? true : false;

	return apply_filters('shprinkone_theme_options_validate', $output, $input, $defaults);
}
