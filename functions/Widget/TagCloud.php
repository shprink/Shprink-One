<?php

class Shprinkone_Widget_Tag_Cloud extends WP_Widget_Tag_Cloud
{

    function __construct()
    {
        parent::__construct();
    }

    function widget($args, $instance)
    {
        extract($args);
        $current_taxonomy = $this->_get_current_taxonomy($instance);
        if (!empty($instance['title'])) {
            $title = $instance['title'];
        } else {
            if ('post_tag' == $current_taxonomy) {
                $title = __('Tags');
            } else {
                $tax = get_taxonomy($current_taxonomy);
                $title = $tax->labels->name;
            }
        }
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);

        echo $before_widget;
        if ($title) echo $before_title . $title . $after_title;
        echo '<div class="tagcloud shprinkone-tagcloud well">';
        wp_tag_cloud(apply_filters('widget_tag_cloud_args', array('taxonomy' => $current_taxonomy)));
        echo "</div>\n";
        echo $after_widget;
    }
}

function shprinkone_widget_tag_cloud_args($args)
{
    $args['number'] = 30;
    $args['smallest'] = 10;
    $args['largest'] = 15;

    // Outputs our edited widget
    return $args;
}

function shprinkone_wp_generate_tag_cloud($taglinks, $tags, $args)
{

    $counts = array();
    foreach ((array)$tags as $key => $tag) {
        $counts[$key] = $tag->count;
    }
    $min_count = min($counts);
    $unit = $args['unit'];
    $spread = max($counts) - $min_count;
    $font_spread = $args['largest'] - $args['smallest'];
    if ($font_spread < 0) {
        $font_spread = 1;
    }
    $font_step = $font_spread / $spread;
    $a = array();
    foreach ($tags as $key => $tag) {
        $count = $tag->count;
        $fontSize = str_replace(',', '.', ( $args['smallest'] + ( ( $count - $min_count ) * $font_step )));
        $tag_link = '#' != $tag->link ? esc_url($tag->link) : '#';
        $tag_id = isset($tags[$key]->id) ? $tags[$key]->id : $key;
        $tag_name = $tags[$key]->name;
        $a[] = "<a href='$tag_link' data-count='$count' style='font-size: "
            . $fontSize . $unit . "' class='tag-link-$tag_id label label-info'>"
            . "<i class='icon-tag'></i> $tag_name</a>";
    }
    return join(' ', $a);
}

function shprinkone_tag_cloud_widgets_init()
{
    unregister_widget('WP_Widget_Tag_Cloud');
    register_widget('Shprinkone_Widget_Tag_Cloud');
    add_filter('widget_tag_cloud_args', 'shprinkone_widget_tag_cloud_args');
    add_filter('wp_generate_tag_cloud', 'shprinkone_wp_generate_tag_cloud', 10, 3);
}
add_action('widgets_init', 'shprinkone_tag_cloud_widgets_init');
