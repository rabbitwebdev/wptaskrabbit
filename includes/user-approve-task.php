<?php
if (!defined('ABSPATH')) {
    exit;
}

// ✅ Register Custom Approval Page URL (/approve-task/)
add_action('init', function () {
    add_rewrite_rule('^approve-task/([0-9]+)/?', 'index.php?approve_task=1&task_id=$matches[1]', 'top');
});

add_filter('query_vars', function ($query_vars) {
    $query_vars[] = 'approve_task';
    $query_vars[] = 'task_id';
    return $query_vars;
});

add_action('template_redirect', function () {
    if (get_query_var('approve_task') == 1) {
        $task_id = intval(get_query_var('task_id'));
        $nonce = isset($_GET['nonce']) ? sanitize_text_field($_GET['nonce']) : '';

        // ✅ Check if Task Exists
        if (!$task_id || get_post_type($task_id) !== 'task') {
            wp_die('Invalid task ID.');
        }

        // ✅ Verify Nonce
        if (!wp_verify_nonce($nonce, 'wprabbit_task_approval_nonce')) {
            wp_die('Invalid approval request.');
        }

        // ✅ Update Task Status to "Approved by User"
        update_post_meta($task_id, 'task_status', 'Approved by User');

        // ✅ Notify Admin that User Approved Task
        wprabbit_notify_admin_task_approved($task_id);

        // ✅ Display Success Message
        echo "<h2>Thank you! You have approved the task.</h2>";
        exit;
    }
});
