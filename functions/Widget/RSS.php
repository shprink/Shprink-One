<?php

class Shprinkone_Widget_RSS extends WP_Widget_RSS
{

    protected $className = 'shprinkone-rss well';

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
