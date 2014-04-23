<?php

class Shprinkone_Widget_Tag_Cloud extends WP_Widget_Tag_Cloud
{

    protected $className = 'shprinkone-tagcloud well';

    function __construct()
    {
        parent::__construct();
    }

    function widget($args, $instance)
    {
        $args['before_widget'] = preg_replace('/class="[^"]*/', '$0 ' . $this->className, $args['before_widget']);
        return parent::widget($args, $instance);
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
