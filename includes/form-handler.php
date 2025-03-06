<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once WPRABBIT_PLUGIN_DIR . 'includes/file-upload.php';
add_action('wp_ajax_wprabbit_submit_task', 'wprabbit_handle_task_submission');
add_action('wp_ajax_nopriv_wprabbit_submit_task', 'wprabbit_handle_task_submission');
// add_action('init', 'wprabbit_handle_task_submission');

function wprabbit_handle_task_submission() {
     if (!isset($_POST['task_name']) || !wp_verify_nonce($_POST['nonce'], 'wprabbit_task_nonce')) {
        wp_send_json_error(['message' => 'Invalid request.']);
    }
    
    // if (isset($_POST['submit_task']) && isset($_POST['wprabbit_task_nonce_field'])) {
    //     if (!wp_verify_nonce($_POST['wprabbit_task_nonce_field'], 'wprabbit_task_nonce')) {
    //         die('Security check failed');
    //     }
        
        $task_id = wp_insert_post(array(
    'post_title'   => sanitize_text_field($_POST['task_name']),
    'post_content' => sanitize_textarea_field($_POST['task_description']),
    'post_status'  => 'pending',
    'post_type'    => 'task',
    'meta_input'   => array(
        'website_name'     => sanitize_text_field($_POST['website_name']),
        'task_date_needed' => sanitize_text_field($_POST['task_date_needed']),
        'task_category'    => sanitize_text_field($_POST['task_category']),
        'task_label'       => sanitize_text_field($_POST['task_label']),
         'task_email'       => sanitize_text_field($_POST['task_email']),
        'task_submitted'   => current_time('Y-m-d H:i:s'),
        'task_status'      => 'Pending', 
    ),
));


  // Ensure task is created
    if (!$task_id || is_wp_error($task_id)) {
        wp_send_json_error(['message' => 'Error submitting task.']);
    }

    // Upload attachment (if provided)
    if (!empty($_FILES['task_attachment']['name'])) {
        $attachment_id = wprabbit_handle_file_upload($_FILES['task_attachment'], $task_id);
        update_post_meta($task_id, 'task_attachment', $attachment_id);
    }
    
     // Notify Admin of New Task
    wprabbit_notify_admin_new_task($task_id);

    // Return New Task Data to Update the Admin Panel Instantly
    wp_send_json_success([
        'message'   => get_option('wprabbit_success_message', 'Thank you! Your task has been submitted.'),
        'task_id'   => $task_id,
        'task_name' => sanitize_text_field($_POST['task_name']),
         'website_name' => sanitize_text_field($_POST['website_name']),
          'task_label' => sanitize_text_field($_POST['task_label']),
          'task_email' => sanitize_text_field($_POST['task_email']),
          'task_date_needed' => sanitize_text_field($_POST['task_date_needed']),
          'task_category' => sanitize_text_field($_POST['task_category']),
        'task_date' => current_time('Y-m-d H:i:s'),
        'task_status' => 'Pending',
    ]);

        // if (!empty($_FILES['task_attachment']['name'])) {
        //     $attachment_id = wprabbit_handle_file_upload($_FILES['task_attachment'], $task_id);
        //     update_post_meta($task_id, 'task_attachment', $attachment_id);
        // }

    //     wp_redirect(add_query_arg('task_submitted', '1', wp_get_referer()));
    //     exit;
    // }
    
//   if ($task_id) {
//         wp_send_json_success(['message' => get_option('wprabbit_success_message', 'Thank you! Your task has been submitted.')]);
//     } else {
//         wp_send_json_error(['message' => 'Error submitting task.']);
//     }
}

  
  
if ($task_id) {
    wprabbit_notify_admin_new_task($task_id);
}
