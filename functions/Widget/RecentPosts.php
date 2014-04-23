<?php

class Shprinkone_Widget_Recent_Posts extends WP_Widget_Recent_Posts
{

    protected $className = 'shprinkone-recentposts well';

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
