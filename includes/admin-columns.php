<?php
if (!defined('ABSPATH')) {
    exit;
}


add_filter('manage_task_posts_columns', function ($columns) {
    $columns['website_name'] = __('Website', 'wp-rabbit-dev');
    $columns['task_date_needed'] = __('Date', 'wp-rabbit-dev');
     $columns['task_category'] = __('Work', 'wp-rabbit-dev');
    $columns['task_label'] = __('Urgency', 'wp-rabbit-dev');
    $columns['task_attachment'] = __('Attachment', 'wp-rabbit-dev');
     $columns['task_email'] = __('Email', 'wp-rabbit-dev');
       $columns['task_status'] = __('Status', 'wp-rabbit-dev');
        $columns['task_cost'] = __('Cost(£)', 'wp-rabbit-dev');
    $columns['task_hours'] = __('Est Hours', 'wp-rabbit-dev');
    return $columns;
});

// Populate custom columns
add_action('manage_task_posts_custom_column', function ($column, $post_id) {
    if ($column === 'website_name') {
        echo esc_html(get_post_meta($post_id, 'website_name', true));
    } elseif ($column === 'task_date_needed') {
        echo esc_html(get_post_meta($post_id, 'task_date_needed', true));
    } elseif ($column === 'task_category') {
        echo esc_html(get_post_meta($post_id, 'task_category', true));
    } elseif ($column === 'task_label') {
        echo esc_html(get_post_meta($post_id, 'task_label', true));
    } elseif ($column === 'task_email') {
        echo esc_html(get_post_meta($post_id, 'task_email', true));
    } elseif ($column === 'task_attachment') {
        $attachment_id = get_post_meta($post_id, 'task_attachment', true);
        if ($attachment_id) {
            $attachment_url = wp_get_attachment_url($attachment_id);
            echo "<a href='" . esc_url($attachment_url) . "' target='_blank'>Download</a>";
        } else {
            echo "No file attached";
        }
    } elseif ($column === 'task_cost') {
         echo "£";
        echo esc_html(get_post_meta($post_id, 'task_cost', true));
    } elseif ($column === 'task_hours') {
        echo esc_html(get_post_meta($post_id, 'task_hours', true));
    }
}, 10, 2);

// add_action('manage_task_posts_custom_column', function ($column, $post_id) {
//     if ($column === 'website_name') {
//         echo esc_html(get_post_meta($post_id, 'website_name', true));
//     } elseif ($column === 'task_date_needed') {
//         echo esc_html(get_post_meta($post_id, 'task_date_needed', true));
//     } elseif ($column === 'task_label') {
//         echo esc_html(get_post_meta($post_id, 'task_label', true));
//     } elseif ($column === 'task_email') {
//         echo esc_html(get_post_meta($post_id, 'task_email', true));
//     } elseif ($column === 'task_attachment') {
//         $attachment_id = get_post_meta($post_id, 'task_attachment', true);
//         if ($attachment_id) {
//             $attachment_url = wp_get_attachment_url($attachment_id);
//             echo "<a href='" . esc_url($attachment_url) . "' target='_blank'>Download</a>";
//         } else {
//             echo "No file attached";
//         }
//     } elseif ($column === 'task_cost') {
//         echo "£";
//         echo esc_html(get_post_meta($post_id, 'task_cost', true)) ?: 'N/A';
//     } elseif ($column === 'task_hours') {
//         echo esc_html(get_post_meta($post_id, 'task_hours', true)) ?: 'N/A';
//         echo "<sm>/hrs</sm>";
//     }
// }, 10, 2);



add_action('save_post_task', function ($post_id) {
    // Avoid triggering the email on autosave or in certain cases
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Ensure we're dealing with the correct post type
    if ('task' !== get_post_type($post_id)) {
        return;
    }

    // Get the current task status
    $status = get_post_meta($post_id, 'task_status', true);

    // If the task is marked as "Completed," send an email
    if ($status === 'Completed') {
        // Get the user's email (you might want to adjust this based on your setup)
        $user_email = get_post_meta($post_id, 'task_email', true); // Assuming 'user_email' is stored as post meta
        
        if ($user_email) {
            $subject = 'Your Task has been Completed';
            $message = 'Hi, your task has been successfully completed. Thank you for your patience!';
            wp_mail($user_email, $subject, $message);
        }
    }
}, 10, 1);

