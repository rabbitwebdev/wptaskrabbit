<?php
if (!defined('ABSPATH')) {
    exit;
}

// Register the "Tasks" Custom Post Type
add_action('init', 'wprabbit_register_task_post_type');

function wprabbit_register_task_post_type() {
    $labels = array(
        'name'               => __('Tasks', 'wp-rabbit-dev'),
        'singular_name'      => __('Task', 'wp-rabbit-dev'),
        'menu_name'          => __('Task Rabbit', 'wp-rabbit-dev'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'capability_type'    => 'post',
        'supports'           => array('title', 'editor', 'custom-fields'),
        'menu_position'      => 5,
        'menu_icon' => plugin_dir_url(__FILE__). '/assets/images/task-rabbit-icon.png', // Adjust path accordingly
    );

    register_post_type('task', $args);
}
