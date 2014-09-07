<?php

class Shprinkone_Widget_Nav_Menu extends WP_Nav_Menu_Widget
{

    protected $className = 'shprinkone-navmenu well';

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
