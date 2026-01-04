<?php
if (!defined('ABSPATH')) {
    exit;
}

// Shortcode for the task submission form
add_shortcode('wprabbit_task_form', function ($atts) {
    if (!is_user_logged_in()) {
        return "<p>You must be logged in to submit a task.</p>";
    }
 $form_layout = get_option('wprabbit_form_layout') === '2' ? 'two-column' : 'one-column';
  $atts = shortcode_atts( [
        'bg_color'   => 'transparent',
    ], $atts, 'wprabbit_task_form' );

    $bg_color = sanitize_text_field( $atts['bg_color'] );
    ob_start();
    ?>
    <div id="wprabbit-task-form-container" class="<?php echo esc_attr($form_layout); ?> <?php echo esc_attr($bg_color); ?>">
    <form id="wprabbit-task-form" class="task-rabbit-form wprabbit-task-form" action="" method="post" >
        <?php wp_nonce_field('wprabbit_task_nonce', 'wprabbit_task_nonce_field'); ?>

        <p class="task-field"><label>Task Name:</label><br>
            <input class="inputs" type="text" name="task_name" required="true">
        </p>

        <p class="task-field"><label>Website Name:</label><br>
            <input class="inputs" type="text" name="website_name" required="true">
        </p>
        
         <p class="task-field"><label>Email:</label><br>
            <input class="inputs" type="text" name="task_email" required="true">
        </p>

        <p class="task-field"><label>Date Needed By:</label><br>
            <input class="inputs" type="date" name="task_date_needed" required="true">
        </p>

        <p class="task-field"><label>Task Category:</label><br>
            <select class="inputs" name="task_category" required="true">
                <option value="Web Page Update">Web Page Update</option>
                <option value="Web Page Build">Web Page Build</option>
                <option value="Website Errors">Website Errors</option>
                <option value="Website Offline">Website Offline</option>
                <option value="Content Update">Content Update</option>
                <option value="Other">Other</option>
            </select>
        </p>

        <p class="task-field"><label>Importance:</label><br>
         <select class="inputs" name="task_label" required="true">
                <option value="None Urgent">None Urgent</option>
                <option value="Urgent">Urgent</option>
            </select>
        </p>

        <p class="task-fieltext"><label>Task Description:</label><br>
            <textarea class="inputs" name="task_description" rows="5" required="true"></textarea>
        </p>

        <p class="task-fieltext"><label>Attach File (optional):</label><br>
            <input class="inputs" type="file" name="task_attachment">
        </p>

        <button class="btn button" type="submit" name="submit_task" value="Submit Task">Submit Task</button>
    </form>
   <div id="wprabbit-task-message" style="display:none;"></div>
       </div>
    <?php
    return ob_get_clean();
});
