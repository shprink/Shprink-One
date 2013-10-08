<?php

/**
 * ADMINISTRATION
 */

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
			'general', '', '__return_false', 'theme_options'
	);

	add_settings_field('slideshow', __('Slideshow', 'shprinkone'), 'shprinkone_settings_field_slideshow', 'theme_options', 'general');
	add_settings_field('posts', __('Post layout on blog, category, tag and author page.', 'shprinkone'), 'shprinkone_settings_field_posts', 'theme_options', 'general');
	add_settings_field('layout', __('Layout', 'shprinkone'), 'shprinkone_settings_field_layout', 'theme_options', 'general');
	add_settings_field('template', __('Theme', 'shprinkone'), 'shprinkone_settings_field_template', 'theme_options', 'general');
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
	echo '<div class="wrap">';
	screen_icon();
	echo '<h2>' . sprintf(__('%s Theme Options', 'shprinkone'), $theme_name) . '</h2>';
	settings_errors();
	echo '<form method="post" action="options.php">';
	settings_fields('shprinkone_options');
	do_settings_sections('theme_options');
	submit_button();
	echo'</form></div>';
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
	// Template selection
	echo '<table class="widefat">';
	echo '<thead><tr>';
	echo '<th style="width:10px;"></th>';
	echo '<th>' . __('Colors', 'shprinkone') . '<br/>[@navbarBackground, @bodyBackground, @linkColor, @textColor]</th>';
	echo '<th>' . __('Name', 'shprinkone') . '</th>';
	echo '<th>' . __('Description', 'shprinkone') . '</th>';
	echo '<th>' . __('Author', 'shprinkone') . '</th>';
	echo '</tr></thead>';
	echo '<tbody>';
	$i = 0;
	foreach (shprinkone_get_theme_templates() as $key => $template) {
		$checked = ($options['theme_template'] == $key) ? 'checked="checked"' : '';
		echo ($i % 2 == 0) ? '<tr>' : '<tr class="alternate">';
		echo '<td><input type="radio" name="shprinkone_theme_options[theme_template]" value="' . $template['value'] . '" ' . $checked . '></td>';
		echo '<td>' . shprinkone_format_template_colors($template['colors']) . '</td>';
		echo '<td>' . $template['name'] . '</td>';
		echo '<td>' . $template['description'] . '</td>';
		echo '<td>' . $template['author'] . '</td>';
		echo '</tr>';
		$i++;
	}
	echo '<tbody>';
	echo '</table>';
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
	echo '<label for="posts_type">' . __('Posts loading type', 'shprinkone') . '</label> ';
	echo '<select id="posts_type" name="shprinkone_theme_options[theme_posts][type]" value="' . $posts_option['type'] . '">';
	foreach (shprinkone_get_theme_posts() as $value => $title) {
		$selected = ($posts_option['type'] === $value) ? 'selected="selected"' : '';
		echo '<option value="' . $value . '" ' . $selected . '>' . $title . '</option>';
	}
	echo '</select><br/>';
	echo '<label for="posts_meta">' . __('Adding meta on each post', 'shprinkone') . '</label> ';
	$checked = (isset($posts_option['meta']) && $posts_option['meta'] == 'on') ? 'checked="checked"' : '';
	echo '<input id="posts_meta" type="checkbox" name="shprinkone_theme_options[theme_posts][meta]" ' . $checked . '>';
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
	for ($index = 0; $index <= 5; $index++) {
		$selected = ((int) $slideshow_option['posts'] === $index) ? 'selected="selected"' : '';
		echo '<option value="' . $index . '" ' . $selected . '>' . $index . '</option>';
	}
	echo '</select><br/>';
	echo '<label for="slideshow_copy_within_content">' . __('Duplicate slideshow posts within the content', 'shprinkone') . '</label> ';
	$checked = (isset($slideshow_option['copy_within_content']) && $slideshow_option['copy_within_content'] == 'on') ? 'checked="checked"' : '';
	echo '<input id="slideshow_copy_within_content" type="checkbox" name="shprinkone_theme_options[theme_slideshow][copy_within_content]" ' . $checked . '>';
}

function shprinkone_format_template_colors($colors) {
	$html = '';
	if (!is_array($colors)) {
		return $html;
	}
	$html .= '<table><tbody><tr>';
	foreach ($colors as $color) {
		$html .= '<td style="height: 5px; width: 5px; background-color:' . $color . '; border:none;"></td>';
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
	return get_option('shprinkone_theme_options', shprinkone_get_theme_default());
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
		'theme_posts' => array(
			'meta' => 'on',
			'type' => 'ajax_scroll'
		),
		'theme_slideshow' => array(
			'posts' => 3
		)
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
	$templateList['custom'] = array(
		'name' => 'Custom',
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
	if (isset($input['theme_layout']) && array_key_exists($input['theme_layout'], shprinkone_get_theme_layouts()))
		$output['theme_layout'] = $input['theme_layout'];

	if (isset($input['theme_template']) && array_key_exists($input['theme_template'], shprinkone_get_theme_templates()))
		$output['theme_template'] = $input['theme_template'];

	if (isset($input['theme_slideshow']))
		$output['theme_slideshow'] = $input['theme_slideshow'];

	if (isset($input['theme_posts'])) {
		if (isset($input['theme_posts']['type']) && array_key_exists($input['theme_posts']['type'], shprinkone_get_theme_posts())) {
			$output['theme_posts']['type'] = $input['theme_posts']['type'];
		}
		if (isset($input['theme_posts']['meta'])) {
			$output['theme_posts']['meta'] = $input['theme_posts']['meta'];
		}
		else{
			$output['theme_posts']['meta'] = false;
		}
	}

	return apply_filters('shprinkone_theme_options_validate', $output, $input, $defaults);
}

