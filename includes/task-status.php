<?php
if (!defined('ABSPATH')) {
    exit;
}
// Load Admin Scripts
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook === 'edit.php' && get_post_type() === 'task') {
        wp_enqueue_script('wprabbit-admin-scripts', plugin_dir_url(__FILE__) . 'admin-scripts.js', array('jquery'), '1.0', true);
    }
});

// Add "Task Status" Column in Admin Panel
add_filter('manage_task_posts_columns', function ($columns) {
    $columns['task_status'] = __('Status', 'wp-rabbit-dev');
    $columns['admin_actions'] = __('Actions', 'wp-rabbit-dev');
    return $columns;
});

// Display Task Status in the Column
add_action('manage_task_posts_custom_column', function ($column, $post_id) {
    if ($column === 'task_status') {
        $status = get_post_meta($post_id, 'task_status', true) ?: 'Pending';
        echo '<strong>' . esc_html($status) . '</strong>';
    }

      if ($column === 'admin_actions') {
        $current_status = get_post_meta($post_id, 'task_status', true) ?: 'Pending';
        ?>
        <select class="task-status-dropdown" data-task-id="<?php echo esc_attr($post_id); ?>">
            <option value="Pending" <?php selected($current_status, 'Pending'); ?>>Pending</option>
            <option value="In Progress" <?php selected($current_status, 'In Progress'); ?>>In Progress</option>
            <option value="Approved" <?php selected($current_status, 'Approved'); ?>>Approved</option>
            <option value="Rejected" <?php selected($current_status, 'Rejected'); ?>>Rejected</option>
            <option value="Completed" <?php selected($current_status, 'Completed'); ?>>Completed</option>
            <option value="Pending Approval" <?php selected($current_status, 'Pending Approval'); ?>>Pending Approval</option>
        </select>
        <span class="task-status-updated" style="color:green; display:none;">✔ Updated</span>
        <?php
    }
}, 10, 2);

// Handle Approve/Reject Task Actions

// Handle AJAX Task Status Update
add_action('wp_ajax_wprabbit_update_task_status', function () {
    if (!isset($_POST['task_id']) || !isset($_POST['new_status']) || !current_user_can('edit_posts')) {
        wp_send_json_error('Invalid request.');
    }

    $task_id = intval($_POST['task_id']);
    $new_status = sanitize_text_field($_POST['new_status']);

    if ($task_id && in_array($new_status, ['Pending', 'In Progress', 'Approved', 'Rejected', 'Pending Approval', 'Completed', 'Approved by User'])) {
        update_post_meta($task_id, 'task_status', $new_status);
      
          wprabbit_notify_user_task_status($task_id, $new_status);

        wp_send_json_success(['message' => 'Task updated successfully.']);
    }

    wp_send_json_error('Failed to update task.');
});

// Handle User Task Approval
add_action('wp_ajax_wprabbit_user_approve_task', 'wprabbit_user_approve_task');
add_action('wp_ajax_nopriv_wprabbit_user_approve_task', 'wprabbit_user_approve_task');

function wprabbit_user_approve_task() {
    if (!isset($_POST['task_id']) || !isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'wprabbit_task_approval_nonce')) {
        wp_send_json_error(['message' => 'Invalid request.']);
    }

    $task_id = intval($_POST['task_id']);

    if (!$task_id || get_post_type($task_id) !== 'task') {
        wp_send_json_error(['message' => 'Invalid task.']);
    }

    update_post_meta($task_id, 'task_status', 'Approved by User');

    // ✅ Notify Admin
    wprabbit_notify_admin_task_approved($task_id);

    wp_send_json_success(['message' => 'Task approved successfully.']);
}

// Handle Approve/Reject Task Actions
// add_action('admin_init', function () {
//     if (!current_user_can('edit_posts')) {
//         return;
//     }

//     if (isset($_GET['approve_task']) && is_numeric($_GET['approve_task'])) {
//         update_post_meta($_GET['approve_task'], 'task_status', 'Approved');
//         wprabbit_notify_user_task_status($_GET['approve_task'], 'Approved'); // Notify User
//         wp_redirect(admin_url('edit.php?post_type=task'));
//         exit;
//     }

//     if (isset($_GET['reject_task']) && is_numeric($_GET['reject_task'])) {
//         update_post_meta($_GET['reject_task'], 'task_status', 'Rejected');
//         wprabbit_notify_user_task_status($_GET['reject_task'], 'Rejected'); // Notify User
//         wp_redirect(admin_url('edit.php?post_type=task'));
//         exit;
//     }
    
//      if (isset($_GET['progress_task']) && is_numeric($_GET['progress_task'])) {
//         update_post_meta($_GET['progress_task'], 'task_status', 'In Progress');
//         wprabbit_notify_user_task_status($_GET['progress_task'], 'In Progress'); // Notify User
//         wp_redirect(admin_url('edit.php?post_type=task'));
//         exit;
//     }
    
//      if (isset($_GET['completed_task']) && is_numeric($_GET['completed_task'])) {
//         update_post_meta($_GET['completed_task'], 'task_status', 'Completed');
//         wprabbit_notify_user_task_status($_GET['completed_task'], 'Completed'); // Notify User
//         wp_redirect(admin_url('edit.php?post_type=task'));
//         exit;
//     }
// });


// Handle Task Approval by User (AJAX)
// add_action('wp_ajax_wprabbit_user_approve_task', 'wprabbit_user_approve_task');
// add_action('wp_ajax_nopriv_wprabbit_user_approve_task', 'wprabbit_user_approve_task');

// function wprabbit_user_approve_task() {
//     if (!isset($_POST['task_id']) || !isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'wprabbit_task_approval_nonce')) {
//         wp_send_json_error(['message' => 'Invalid request.']);
//     }

//     $task_id = intval($_POST['task_id']);

//     if (!$task_id || get_post_type($task_id) !== 'task') {
//         wp_send_json_error(['message' => 'Invalid task.']);
//     }

//     update_post_meta($task_id, 'task_status', 'Approved by User');

//     // Notify Admin that User Approved Task
//     wprabbit_notify_admin_task_approved($task_id);

//     wp_send_json_success(['message' => 'Task approved successfully.']);
// }

