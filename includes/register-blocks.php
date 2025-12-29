<?php
if (!defined('ABSPATH')) {
    exit;
}

// Register Gutenberg Block
// add_action('init', function () {
//     register_block_type(__DIR__ . '/blocks/task-form');
// });

add_action('init', function () {
   

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

     wp_register_script(
        'task-block-editor',
        plugin_dir_url(__FILE__) . 'blocks/task-form/editor.js',
        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n' ],
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/task-form/editor.js' ),
        true
    );

     register_block_type( plugin_dir_path( __FILE__ ) . 'includes/blocks/task-form/', [
        'editor_script' => 'task-block-editor',
        'style'         => 'wprabbit-task-form-style',
    ]);
});
