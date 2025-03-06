<?php
if (!defined('ABSPATH')) {
    exit;
}

// Add Settings Page
add_action('admin_menu', function () {
    add_options_page(
        'Task Rabbit Settings',
        'Task Rabbit',
        'manage_options',
        'wprabbit-dev-settings',
        'wprabbit_settings_page'
    );
});

// Register Settings
add_action('admin_init', function () {
    register_setting('wprabbit_settings_group', 'wprabbit_form_bg_color');
    register_setting('wprabbit_settings_group', 'wprabbit_form_text_color');
    register_setting('wprabbit_settings_group', 'wprabbit_form_text_size');
    register_setting('wprabbit_settings_group', 'wprabbit_form_button_color');
    register_setting('wprabbit_settings_group', 'wprabbit_form_border_radius');
     register_setting('wprabbit_settings_group', 'wprabbit_form_input_radius');
      register_setting('wprabbit_settings_group', 'wprabbit_success_message');
       register_setting('wprabbit_settings_group', 'wprabbit_page_restrict_message');
       register_setting('wprabbit_settings_group', 'wprabbit_single_task_message');
register_setting('wprabbit_settings_group', 'wprabbit_form_layout');
      register_setting('wprabbit_settings_group', 'wprabbit_email_task_status_subject');
       register_setting('wprabbit_settings_group', 'wprabbit_email_task_status_body');
});

// Settings Page Output
function wprabbit_settings_page() {
    ?>
    <div class="wrap task-rabbit-settings">
        <h1>Task Rabbit</h1>
        <h2>Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('wprabbit_settings_group'); ?>
            <?php do_settings_sections('wprabbit-dev-settings'); ?>

            <table class="form-table tr-table table table-striped">
                <tr>
                    <th><label for="wprabbit_form_bg_color">Form Background Color</label></th>
                    <td><input type="color" id="wprabbit_form_bg_color" name="wprabbit_form_bg_color" value="<?php echo esc_attr(get_option('wprabbit_form_bg_color', '#ffffff')); ?>"></td>
                </tr>
                
                <tr>
                    <th><label for="wprabbit_form_border_radius">Form Border Radius (px)</label></th>
                    <td><input type="number" id="wprabbit_form_border_radius" name="wprabbit_form_border_radius" value="<?php echo esc_attr(get_option('wprabbit_form_border_radius', '5')); ?>"></td>
                </tr>
                
                 <tr>
                    <th><label for="wprabbit_form_input_radius">Input Radius (px)</label></th>
                    <td><input type="number" id="wprabbit_form_input_radius" name="wprabbit_form_input_radius" value="<?php echo esc_attr(get_option('wprabbit_form_input_radius', '5')); ?>"></td>
                </tr>

                <tr>
                    <th><label for="wprabbit_form_text_color">Form Text Color</label></th>
                    <td><input type="color" id="wprabbit_form_text_color" name="wprabbit_form_text_color" value="<?php echo esc_attr(get_option('wprabbit_form_text_color', '#000000')); ?>"></td>
                </tr>
                
                 <tr>
                    <th><label for="wprabbit_form_text_size">Form Text Size</label></th>
                    <td><input type="number" id="wprabbit_form_text_size" name="wprabbit_form_text_size" value="<?php echo esc_attr(get_option('wprabbit_form_text_size', '12')); ?>"></td>
                </tr>

                <tr>
                    <th><label for="wprabbit_form_button_color">Form Button Color</label></th>
                    <td><input type="color" id="wprabbit_form_button_color" name="wprabbit_form_button_color" value="<?php echo esc_attr(get_option('wprabbit_form_button_color', '#0073aa')); ?>"></td>
                </tr>

                
                
              <tr>
                
            <th><label class="switch">Choose form layout</th>
           
                <td><input type="checkbox" id="wprabbit_form_layout" name="wprabbit_form_layout" value="2" 
                <?php checked(get_option('wprabbit_form_layout'), '2'); ?>>
                <span class="slider round"></span> Enable 2-Column Layout </td>
            </label>
            </tr>
                 <tr>
                    <th><label for="wprabbit_success_message">Custom Success Message</label></th>
                    <td>
                        <input type="text" id="wprabbit_success_message" name="wprabbit_success_message" 
                        value="<?php echo esc_attr(get_option('wprabbit_success_message', 'Thank you! Your task has been submitted.')); ?>" 
                        class="regular-text">
                    </td>
                </tr>
                
                <tr>
                    <th><label for="wprabbit_page_restrict_message">Custom Page Message</label></th>
                    <td>
                        <input type="text" id="wprabbit_page_restrict_message" name="wprabbit_page_restrict_message" 
                        value="<?php echo esc_attr(get_option('wprabbit_page_restrict_message', 'No WAYYY.')); ?>" 
                        class="regular-text">
                    </td>
                </tr>
                
                <tr>
                    <th><label for="wprabbit_single_task_message">Page Message</label></th>
                    <td>
                        <textarea type="textarea" id="wprabbit_single_task_message" name="wprabbit_single_task_message" 
                        value="<?php echo esc_attr(get_option('wprabbit_single_task_message', 'Message.')); ?>" 
                        class="regular-text"><?php echo esc_attr(get_option('wprabbit_single_task_message', 'Message.')); ?></textarea>
                    </td>
                </tr>
                
            </table>
            
             

           

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
