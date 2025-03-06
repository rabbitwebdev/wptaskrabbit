<?php
if (!defined('ABSPATH')) {
    exit;
}

// ✅ Register Task Template
add_filter('template_include', function ($template) {
    if (is_singular('task')) {
        return plugin_dir_path(__FILE__) . '/templates/single-task.php';
    }
    return $template;
});
