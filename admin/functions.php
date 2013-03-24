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
	'shprinkone_options', // Options group, see settings_fields() call in twentyeleven_theme_options_render_page()
	'shprinkone_theme_options', // Database option, see twentyeleven_get_theme_options()
	'shprinkone_theme_options_validate' // The sanitization callback, see twentyeleven_theme_options_validate()
	);
	// Register our settings field group
	add_settings_section(
	'general', // Unique identifier for the settings section
	'', // Section title (we don't want one)
	'__return_false', // Section callback (we don't want anything)
	'theme_options' // Menu slug, used to uniquely identify the page; see twentyeleven_theme_options_add_page()
	);

	add_settings_field('layout', __('Default Layout', 'shprinkone'), 'shprinkone_settings_field_layout', 'theme_options', 'general');
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
	$theme_name = function_exists('wp_get_theme') ? wp_get_theme() : get_current_theme();
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
	foreach (shprinkone_layouts() as $layout) {
		$checked = ($options['theme_layout'] == $layout['value']) ? 'checked="checked"' : '';
		$html = '<div class="layout image-radio-option theme-layout">';
		$html .= '<label class="description"> <input type="radio" name="shprinkone_theme_options[theme_layout]"';
		$html .= 'value="' . esc_attr($layout['value']) . '" ' . $checked . ' /> <span>';
		$html .= '<img src="' . esc_url($layout['thumbnail']) . '" width="136" height="122" alt="" />';
		$html .= $layout['label'];
		$html .= '</span></label></div>';
		echo $html;
	}
}

/**
 * Get theme options
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_get_theme_options() {
	return get_option('shprinkone_theme_options', shprinkone_get_default_theme_options());
}

/**
 * Get default theme options
 *
 * @return  void
 * @since   1.0
 */
function shprinkone_get_default_theme_options() {
	$default_theme_options = array(
		'theme_layout' => 'content-sidebar',
	);

	if (is_rtl())
		$default_theme_options['theme_layout'] = 'sidebar-content';

	return apply_filters('shprinkone_default_theme_options', $default_theme_options);
}

/**
 * Set Layouts
 *
 * @return  mixed
 * @since   1.0
 */
function shprinkone_layouts() {
	$layout_options = array(
		'content-sidebar' => array(
			'value' => 'content-sidebar',
			'label' => __('Content on left', 'shprinkone'),
			'thumbnail' => get_template_directory_uri() . '/img/content-sidebar.png',
		),
		'sidebar-content' => array(
			'value' => 'sidebar-content',
			'label' => __('Content on right', 'shprinkone'),
			'thumbnail' => get_template_directory_uri() . '/img/sidebar-content.png',
		),
		'content' => array(
			'value' => 'content',
			'label' => __('One-column, no sidebar', 'shprinkone'),
			'thumbnail' => get_template_directory_uri() . '/img/content.png',
		),
	);

	return apply_filters('shprinkone_layouts', $layout_options);
}

/**
 * Templates raw data
 *
 * @return  mixed
 * @since   1.0
 */
function shprinkone_templates() {
	$templateList = array(
		'cerulean' => array(
			'name'=> 'cerulean',
			'path' =>get_template_directory_uri() . '/css/cerulean.bootswatch.min.css',
		),
		'cosmo' => array(
			'name'=> 'cosmo',
			'path' =>get_template_directory_uri() . '/css/cosmo.bootswatch.min.css',
		),
		'cyborg' => array(
			'name'=> 'cyborg',
			'path' =>get_template_directory_uri() . '/css/cyborg.bootswatch.min.css',
		),
		'amelia' => array(
			'name'=> 'amelia',
			'path' =>get_template_directory_uri() . '/css/amelia.bootswatch.min.css',
		),
		'readable' => array(
			'name'=> 'readable',
			'path' =>get_template_directory_uri() . '/css/readable.bootswatch.min.css',
		),
		'slate' => array(
			'name'=> 'slate',
			'path' =>get_template_directory_uri() . '/css/slate.bootswatch.min.css',
		),
		'united' => array(
			'name'=> 'united',
			'path' =>get_template_directory_uri() . '/css/united.bootswatch.min.css',
		),
		'custom' => array(
			'name'=> 'custom',
			'path' =>get_template_directory_uri() . '/css/custom.css',
		),
	);
	return apply_filters('shprinkone_templates', $templateList);
}

/**
 * Validate theme options
 *
 * @return  mixed
 * @since   1.0
 */
function shprinkone_theme_options_validate($input) {
	$output = $defaults = shprinkone_get_default_theme_options();

	// Theme layout must be in our array of theme layout options
	if (isset($input['theme_layout']) && array_key_exists($input['theme_layout'], shprinkone_layouts()))
		$output['theme_layout'] = $input['theme_layout'];

	return apply_filters('shprinkone_theme_options_validate', $output, $input, $defaults);
}

