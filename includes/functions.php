<?php
if (!defined('ABSPATH')) {
    exit;
}

function task_rabbit_enqueue_styles() {
    wp_enqueue_style('task-rabbit-style', plugin_dir_url(__FILE__) . 'rabbit-styles.css');
}
add_action('admin_enqueue_scripts', 'task_rabbit_enqueue_styles');

function wp_task_rabbit_enqueue_styles() {
     wp_enqueue_style('task-rabbit-single-task', plugin_dir_url(__FILE__) . 'single-task-styles.css');
}
add_action('wp_enqueue_scripts', 'wp_task_rabbit_enqueue_styles');