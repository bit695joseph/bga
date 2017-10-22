<?php
namespace bga\app {


    /**
     * Class NavItem
     *
     * Simple container for nav item info.
     *
     * @package bga\app
     */
    class NavItem
    {
        public $title;
        public $href;
        public $activeClass = '';
        public $disabledClass = '';

        function __construct($title, $href = '#')
        {
            $this->title = $title;
            $this->href = $href;
        }
    }
}