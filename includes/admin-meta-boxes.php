<?php
if (!defined('ABSPATH')) {
    exit;
}

// Add Meta Box for Cost & Estimated Hours
add_action('add_meta_boxes', function () {
    add_meta_box(
        'task_cost_hours_meta',
        __('Task Cost & Estimated Hours', 'wp-rabbit-dev'),
        'wprabbit_task_cost_hours_meta_box',
        'task',
        'side',
        'default'
    );
     add_meta_box(
        'task_details_meta',
        __('Task Details', 'wp-rabbit-dev'),
        'wprabbit_task_details_meta_box',
        'task',
        'normal',
        'high'
    );
     add_meta_box(
        'task_admin_notes_meta',
        __('Admin Notes', 'wp-rabbit-dev'),
        'wprabbit_admin_notes_meta_box',
        'task',
        'normal',
        'high'
    );
});

// Display Fields in Meta Box
function wprabbit_task_details_meta_box($post) {
    // Retrieve saved values
    $website_name = get_post_meta($post->ID, 'website_name', true);
    $task_date_needed = get_post_meta($post->ID, 'task_date_needed', true);
    $task_category = get_post_meta($post->ID, 'task_category', true);
    $task_label = get_post_meta($post->ID, 'task_label', true);
    $task_email = get_post_meta($post->ID, 'task_email', true);
    $task_submitted = get_post_meta($post->ID, 'task_submitted', true);
    $task_status = get_post_meta($post->ID, 'task_status', true);
    $task_attachment = get_post_meta($post->ID, 'task_attachment', true);
     $author_id = $post->post_author;
      $user_info = get_userdata($author_id);
   

    wp_nonce_field('wprabbit_task_details_nonce', 'wprabbit_task_details_nonce_field');
    ?>

    <table class="form-table">
         <tr>
            <th><label for="user_name">User Name</label></th>
            <td><input type="text" disabled id="user_name" name="user_name" value="<?php  echo '' . esc_html($user_info->user_login); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="website_name">Website Name</label></th>
            <td><input type="text" id="website_name" name="website_name" value="<?php echo esc_attr($website_name); ?>" class="regular-text"></td>
        </tr>

        <tr>
            <th><label for="task_date_needed">Date Needed By</label></th>
            <td><input type="date" id="task_date_needed" name="task_date_needed" value="<?php echo esc_attr($task_date_needed); ?>"></td>
        </tr>

        <tr>
            <th><label for="task_category">Task Category</label></th>
            <td>
                <select id="task_category" name="task_category">
                    <?php
                    $options = ['Web Page Update', 'Web Page Build', 'Website Errors', 'Website Offline', 'Content Update', 'Other'];
                    foreach ($options as $option) {
                        echo '<option value="' . esc_attr($option) . '" ' . selected($task_category, $option, false) . '>' . esc_html($option) . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <th><label for="task_label">Task Label</label></th>
            <td>
                <select id="task_label" name="task_label">
                    <option value="None Urgent" <?php selected($task_label, 'None Urgent'); ?>>None Urgent</option>
                    <option value="Urgent" <?php selected($task_label, 'Urgent'); ?>>Urgent</option>
                </select>
            </td>
        </tr>

        <tr>
            <th><label for="task_email">User Email</label></th>
            <td><input type="email" id="task_email" name="task_email" value="<?php echo esc_attr($task_email); ?>" class="regular-text"></td>
        </tr>

        <tr>
            <th><label>Task Submitted</label></th>
            <td><input type="text" value="<?php echo esc_attr($task_submitted); ?>" readonly class="regular-text"></td>
        </tr>
       
         <tr>
            <th><label>File</label></th>
            <td><input type="file" value="<?php echo esc_attr($task_attachment); ?>" class="regular-text"></td>
        </tr>

        <tr>
            <th><label for="task_status">Task Status</label></th>
            <td>
                <select id="task_status" name="task_status">
                    <option value="Pending" <?php selected($task_status, 'Pending'); ?>>Pending</option>
                    <option value="Pending Approval" <?php selected($task_status, 'Pending Approval'); ?>>Pending Approval</option>
                    <option value="In Progress" <?php selected($task_status, 'In Progress'); ?>>In Progress</option>
                    <option value="Approved" <?php selected($task_status, 'Approved'); ?>>Approved</option>
                    <option value="Rejected" <?php selected($task_status, 'Rejected'); ?>>Rejected</option>
                    <option value="Completed" <?php selected($task_status, 'Completed'); ?>>Completed</option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

// Save Task Details
add_action('save_post', function ($post_id) {
    if (!isset($_POST['wprabbit_task_details_nonce_field']) || !wp_verify_nonce($_POST['wprabbit_task_details_nonce_field'], 'wprabbit_task_details_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, 'website_name', sanitize_text_field($_POST['website_name']));
    update_post_meta($post_id, 'task_date_needed', sanitize_text_field($_POST['task_date_needed']));
    update_post_meta($post_id, 'task_category', sanitize_text_field($_POST['task_category']));
    update_post_meta($post_id, 'task_label', sanitize_text_field($_POST['task_label']));
    update_post_meta($post_id, 'task_email', sanitize_email($_POST['task_email']));
    update_post_meta($post_id, 'task_status', sanitize_text_field($_POST['task_status']));
});

// Meta Box Display Function
function wprabbit_task_cost_hours_meta_box($post) {
    $task_cost = get_post_meta($post->ID, 'task_cost', true);
    $task_hours = get_post_meta($post->ID, 'task_hours', true);
    wp_nonce_field('wprabbit_task_cost_hours_nonce', 'wprabbit_task_cost_hours_nonce_field');
    ?>

    <p>
        <label for="task_cost"><?php _e('Task Cost', 'wp-rabbit-dev'); ?></label><br>
        <input type="number" id="task_cost" name="task_cost" value="<?php echo esc_attr($task_cost); ?>" step="0.01">
    </p>

    <p>
        <label for="task_hours"><?php _e('Estimated Hours', 'wp-rabbit-dev'); ?></label><br>
        <input type="number" id="task_hours" name="task_hours" value="<?php echo esc_attr($task_hours); ?>" step="0.1">
    </p>

    <?php
}

// Save Meta Box Data
add_action('save_post', function ($post_id) {
    if (!isset($_POST['wprabbit_task_cost_hours_nonce_field']) || 
        !wp_verify_nonce($_POST['wprabbit_task_cost_hours_nonce_field'], 'wprabbit_task_cost_hours_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['task_cost'])) {
        update_post_meta($post_id, 'task_cost', sanitize_text_field($_POST['task_cost']));
    }

    if (isset($_POST['task_hours'])) {
        update_post_meta($post_id, 'task_hours', sanitize_text_field($_POST['task_hours']));
    }
});


function wprabbit_admin_notes_meta_box($post) {
    $admin_notes = get_post_meta($post->ID, 'task_admin_notes', true);

    wp_nonce_field('wprabbit_task_admin_notes_nonce', 'wprabbit_task_admin_notes_nonce_field');
    ?>
    <table class="form-table">
        <tr>
            <th><label for="task_admin_notes">Notes for User</label></th>
            <td>
                <textarea id="task_admin_notes" name="task_admin_notes" rows="5" class="large-text"><?php 
                    echo esc_textarea($admin_notes); 
                ?></textarea>
                <p class="description">These notes will be visible to the task creator on the single task page.</p>
            </td>
        </tr>
    </table>
    <?php
}

// ✅ Save Admin Notes
add_action('save_post', function ($post_id) {
    if (!isset($_POST['wprabbit_task_admin_notes_nonce_field']) || !wp_verify_nonce($_POST['wprabbit_task_admin_notes_nonce_field'], 'wprabbit_task_admin_notes_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, 'task_admin_notes', sanitize_textarea_field($_POST['task_admin_notes']));
});

