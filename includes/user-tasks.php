<?php
if (!defined('ABSPATH')) {
    exit;
}

// Shortcode to Display User's Submitted Tasks
add_shortcode('wprabbit_user_tasks', 'wprabbit_display_user_tasks');

function wprabbit_display_user_tasks() {
    if (!is_user_logged_in()) {
        return "<p>You must be logged in to view your submitted tasks.</p>";
    }

    $current_user_id = get_current_user_id();
    $args = array(
        'post_type'      => 'task',
        'post_status'    => 'any',
        'author'         => $current_user_id,
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC'
    );

    $tasks = new WP_Query($args);

    if (!$tasks->have_posts()) {
        return "<p>You have not submitted any tasks yet.</p>";
    }

    ob_start();
    ?>
    <div class="table-responsive wp-rabbit-table-wrps">

    <table class=" table table-striped wprabbit-task-table">
        <thead>
            <tr>
                <th><?php _e('Task', 'wp-rabbit-dev'); ?></th>
                 <th><?php _e('Website', 'wp-rabbit-dev'); ?></th>

                  <th><?php _e('Cost', 'wp-rabbit-dev'); ?></th>
                <th><?php _e('Est hrs', 'wp-rabbit-dev'); ?></th>
                 <th><?php _e('Status', 'wp-rabbit-dev'); ?></th>
                 <th><?php _e('View', 'wp-rabbit-dev'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($tasks->have_posts()) : $tasks->the_post();
                $task_id = get_the_ID();
                $task_category = get_post_meta($task_id, 'task_category', true);
                $task_label = get_post_meta($task_id, 'task_label', true);
                $task_website = get_post_meta($task_id, 'website_name', true);
                $task_status = get_post_meta($task_id, 'task_status', true) ?: 'Pending';
                 $task_date = get_post_meta($task_id, 'task_date_needed', true);
                $attachment_id = get_post_meta($task_id, 'task_attachment', true);
                $attachment_url = $attachment_id ? wp_get_attachment_url($attachment_id) : '';
                   $task_cost = get_post_meta($task_id, 'task_cost', true) ?: 'N/A';
                $task_hours = get_post_meta($task_id, 'task_hours', true) ?: 'N/A';
                $task_link = get_permalink($task_id);
            ?>
                <tr>
                    <td><?php the_title(); ?></td>
                    <td><?php echo esc_html($task_website); ?></td>

                   
                  <td><?php if ( $task_cost)  { ?>£<?php echo esc_html($task_cost); ?><?php } else { ?> bbjbjbjbj<?php } ?></td>
                    <td><?php echo esc_html($task_hours); ?>/hours</td>
                                        <td><strong><?php echo esc_html($task_status); ?></strong></td>
                                        <td><a href="<?php echo esc_url($task_link); ?>">View</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>

    <?php
    wp_reset_postdata();
    return ob_get_clean();
}
