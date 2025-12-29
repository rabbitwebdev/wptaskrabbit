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
         'render_callback' => 'wp_render_task_block',
    ]);
});


function wp_render_task_block( $attributes ) {
    $limit      = isset( $attributes['limit'] ) ? absint( $attributes['limit'] ) : 6;
    $min_rating = isset( $attributes['minRating'] ) ? absint( $attributes['minRating'] ) : 1;
    $show_stars = isset( $attributes['showStars'] ) ? (bool) $attributes['showStars'] : true;
    $show_date  = isset( $attributes['showDate'] ) ? (bool) $attributes['showDate'] : true;
    $show_text  = isset( $attributes['showText'] ) ? (bool) $attributes['showText'] : true;
     $layout = isset( $attributes['layout'] ) ? $attributes['layout'] : 'grid';
     $bg_color = isset( $attributes['bgColor'] ) ? $attributes['bgColor'] : 'transparent';
     $padding = isset( $attributes['padding'] ) ? $attributes['padding'] : 'none';
     $title = isset( $attributes['title'] ) ? sanitize_text_field( $attributes['title'] ) : 'Google Reviews';
     $btn_url = isset( $attributes['btnUrl'] ) ? esc_url_raw( $attributes['btnUrl'] ) : '';
     $btn_text = isset( $attributes['btnText'] ) ? sanitize_text_field( $attributes['btnText'] ) : 'Read More Reviews';

    return do_shortcode( sprintf(
        '[wprabbit_task_form limit="%d" min_rating="%d" show_stars="%d" show_date="%d" show_text="%d" layout="%s" bg_color="%s" padding="%s"     title="%s" btn_url="%s" btn_text="%s"]',
        max( 1, $limit ),
        min( 5, max( 1, $min_rating ) ),
        $show_stars ? 1 : 0,
        $show_date ? 1 : 0,
        $show_text ? 1 : 0,
        $layout,
        $bg_color,
        $padding,
        $title,
        $btn_url,
        $btn_text
    ) );
}
