<?php
if (!defined('ABSPATH')) {
    exit;
}

// Register Gutenberg Block
// add_action('init', function () {
//     register_block_type(__DIR__ . '/blocks/task-form');
// });

add_action('init', function () {
    register_block_type(__DIR__ . '/blocks/task-form/');

    wp_register_script(
        'wprabbit-task-form-editor-script',
        plugin_dir_url(__FILE__) . '/blocks/task-form/index.js',
        array('wp-blocks', 'wp-editor'),
        filemtime(plugin_dir_path(__FILE__) . '/blocks/task-form/index.js'),
        true
    );

    wp_register_style(
        'wprabbit-task-form-style',
        plugin_dir_url(__FILE__) . '/blocks/task-form/style.css',
        array(),
        filemtime(plugin_dir_path(__FILE__) . '/blocks/task-form/style.css')
    );
});
