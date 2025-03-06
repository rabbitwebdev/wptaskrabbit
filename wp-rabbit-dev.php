<?php
/**
 * Plugin Name: WP Task Rabbit
 * Plugin URI:  https://dev.rabbitwebdesign.co.uk
 * Description: A task managment plugin.
 * Version:     2.0
 * Author:      P York
 * Author URI:  https://rabbitwebdesign.co.uk
 * License:     GPL2
 * Text Domain: wp-rabbit-dev
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Define plugin path
define('WPRABBIT_PLUGIN_DIR', plugin_dir_path(__FILE__));


require_once WPRABBIT_PLUGIN_DIR . 'includes/post-type.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/shortcode.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/form-handler.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/admin-columns.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/file-upload.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/task-status.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/email-notifications.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/user-tasks.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/admin-meta-boxes.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/settings.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/frontend-style.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/register-blocks.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/functions.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/task-template.php';
require_once WPRABBIT_PLUGIN_DIR . 'includes/user-approve-task.php';


// Enqueue Frontend Scripts
function wprabbit_enqueue_scripts() {
    wp_enqueue_script('wprabbit-task-form', plugin_dir_url(__FILE__) . 'includes/assets/js/task-form.js', array('jquery'), '1.1', true);
    wp_localize_script('wprabbit-task-form', 'wprabbit_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));
     wp_enqueue_script('wprabbit-user-approval', plugin_dir_url(__FILE__) . 'includes/assets/js/user-approval.js', array('jquery'), '2.0', true);
    wp_localize_script('wprabbit-user-approval', 'wprabbit_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));
     wp_enqueue_script('wprabbit-task-approval', plugin_dir_url(__FILE__) . 'includes/assets/js/task-approval.js', array('jquery'), '1.0', true);
    wp_localize_script('wprabbit-task-approval', 'wprabbit_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'wprabbit_enqueue_scripts');




