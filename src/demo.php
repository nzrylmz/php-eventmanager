<?php

require_once __DIR__ . '/../vendor/autoload.php';

use nzrylmz\EventManager;

EventManager::add_action('menu_generate', function($menu) {
    return ['Home', 'About', 'Contact'];
}, 10);
EventManager::add_action('menu_generate', function($menu) {
    $menu = array_merge($menu, ['Services', 'Portfolio']);
    return $menu;
}, 20);


$final_menu = EventManager::do_action('menu_generate');

print_r($final_menu);