<?php
if (!defined('ABSPATH')) {
    exit;
}


/**
 * Send Email to User to Approve Task
 */
function wprabbit_notify_user_task_approval($task_id) {
    $task_author_id = get_post_field('post_author', $task_id);
    $user_info = get_userdata($task_author_id);

    if (!$user_info) return;

    $task_title = get_the_title($task_id);
    $email = $user_info->user_email;
    $task_cost = get_post_meta($task_id, 'task_cost', true) ?: 'N/A';
    $task_hours = get_post_meta($task_id, 'task_hours', true) ?: 'N/A';
    $task_link = site_url('/approve-task?task_id=' . $task_id . '&nonce=' . wp_create_nonce('wprabbit_task_approval_nonce'));

    $subject = "Please Approve Your Task Cost";

    $message = "
    <html>
    <body>
        <h2>Your Task Requires Approval</h2>
        <p>Hello " . esc_html($user_info->display_name) . ",</p>
        <p>Your task <strong>" . esc_html($task_title) . "</strong> has been reviewed by the admin.</p>
        <p><strong>Cost:</strong> $" . esc_html($task_cost) . "</p>
        <p><strong>Estimated Hours:</strong> " . esc_html($task_hours) . " hours</p>
        <p>Please click the button below to approve the cost:</p>
        <p><a href='" . esc_url($task_link) . "' style='background-color: #0073aa; color: white; padding: 10px 20px; text-decoration: none;'>Approve Task</a></p>
    </body>
    </html>";

    wp_mail($email, $subject, $message, ['Content-Type: text/html; charset=UTF-8']);
}

/**
 * Send Email Notification to Admin when a Task is Submitted
 */
function wprabbit_notify_admin_new_task($task_id) {
    $admin_email = get_option('admin_email'); // Get admin email
    $task_title = get_the_title($task_id);
    $task_author = get_userdata(get_post_field('post_author', $task_id));
    
    $subject = "New Task Submitted: $task_title";
    $message = "A new task has been submitted by " . esc_html($task_author->display_name) . ".\n\n";
    $message .= "Task Name: " . esc_html($task_title) . "\n";
    $message .= "Task Description: " . esc_html(get_post_field('post_content', $task_id)) . "\n";
    $message .= "View Task: " . esc_url(admin_url("post.php?post=$task_id&action=edit")) . "\n\n";
    
    wp_mail($admin_email, $subject, $message);
}

/**
 * Send Custom Email Notification to User when Task Status Changes
 */
// function wprabbit_notify_user_task_status($task_id, $status) {
//     $task_author_id = get_post_field('post_author', $task_id);
//     $user_info = get_userdata($task_author_id);
    
//     if (!$user_info) return;

//     $task_title = get_the_title($task_id);
//     $email = $user_info->user_email;
//     $task_cost = get_post_meta($task_id, 'task_cost', true) ?: 'N/A';
//     $task_hours = get_post_meta($task_id, 'task_hours', true) ?: 'N/A';
//     $task_link = get_permalink($task_id);
//     $site_name = get_bloginfo('name');
//     $site_url = get_bloginfo('url');

//     // Get email subject & body from settings
//     $subject_template = get_option('wprabbit_email_task_status_subject', 'Your Task is Now {task_status} - {site_name}');
//     $body_template = get_option('wprabbit_email_task_status_body', 
//         "Hello {user_name},\n\nYour task \"{task_name}\" has been updated to {task_status}.\n\nCost: ${task_cost}\nEstimated Hours: {task_hours} hours\n\nVisit {site_name}: {site_url}"
//     );

//     // Replace placeholders with dynamic values
//     $subject = str_replace(
//         ['{task_name}', '{task_status}', '{task_cost}', '{task_hours}', '{user_name}', '{site_name}', '{site_url}'],
//         [$task_title, $status, $task_cost, $task_hours, $user_info->display_name, $site_name, $site_url],
//         $subject_template
//     );

//     $message = str_replace(
//         ['{task_name}', '{task_status}', '{task_cost}', '{task_hours}', '{user_name}', '{site_name}', '{site_url}'],
//         [$task_title, $status, $task_cost, $task_hours, $user_info->display_name, $site_name, $site_url],
//         nl2br($body_template)
//     );

//     // Set email headers for HTML email
//     $headers = array(
//         'Content-Type: text/html; charset=UTF-8',
//         'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
//     );

//     wp_mail($email, $subject, $message, $headers);
// }


/**
 * Send HTML Email Notification to User when Task Status Changes
 */
function wprabbit_notify_user_task_status($task_id, $status) {
    $task_author_id = get_post_field('post_author', $task_id);
    $user_info = get_userdata($task_author_id);
    
    if (!$user_info) return;

    $task_title = get_the_title($task_id);
    $email = $user_info->user_email;
    $task_cost = get_post_meta($task_id, 'task_cost', true) ?: 'N/A';
    $task_hours = get_post_meta($task_id, 'task_hours', true) ?: 'N/A';
    $site_name = get_bloginfo('name');
    $site_url = get_bloginfo('url');
 $task_link = get_permalink($task_id);
    $subject = "Your Task is Now $status - $site_name";

    // Set email headers for HTML email
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
    );

    // Email content with HTML formatting
    $message = '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; }
            .email-container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); }
            h2 { color: #333; }
            .task-details { width: 100%; border-collapse: collapse; margin-top: 20px; }
            .task-details th, .task-details td { text-align: left; padding: 10px; border-bottom: 1px solid #ddd; }
            .task-details th { background-color: #0073aa; color: #ffffff; }
            .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #777; }
            .button { background-color: #0073aa; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 10px; }
            .button:hover { background-color: #005f8d; }
        </style>
    </head>
    <body>
        <div class="email-container">
            <h2>Your Task Update: <strong>' . esc_html($task_title) . '</strong></h2>
            <p>Dear ' . esc_html($user_info->display_name) . ',</p>
            <p>Your task has been updated to: <strong>' . esc_html($status) . '</strong>.</p>

            <table class="task-details">
                <tr>
                    <th>Task Name</th>
                    <td>' . esc_html($task_title) . '</td>
                </tr>
                <tr>
                    <th>Cost</th>
                    <td>£' . esc_html($task_cost) . '</td>
                </tr>
                <tr>
                    <th>Estimated Hours</th>
                    <td>' . esc_html($task_hours) . ' hours</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><strong>' . esc_html($status) . '</strong></td>
                </tr>
            </table>

            <p style="text-align: center;">
                <a href="' . esc_url($task_link) . '" class="button">View Task</a>
            </p>

            <p>Best regards,<br><strong>' . esc_html($site_name) . '</strong></p>

            <div class="footer">
                <p>&copy; ' . date("Y") . ' <a href="' . esc_url($site_url) . '">' . esc_html($site_name) . '</a>. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>';

    wp_mail($email, $subject, $message, $headers);
}