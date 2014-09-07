<?php

class Shprinkone_Widget_Categories extends WP_Widget_Categories
{

    protected $className = 'shprinkone-categories well';

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
