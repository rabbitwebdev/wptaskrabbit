<?php
if (!defined('ABSPATH')) {
    exit;
}

// Get Task Data
$task_id = get_the_ID();
$current_user_id = get_current_user_id();
$task_author_id = get_post_field('post_author', $task_id);
$task_title = get_the_title();
$task_description = get_the_content();
$task_status = get_post_meta($task_id, 'task_status', true) ?: 'Pending';
$task_cost = get_post_meta($task_id, 'task_cost', true) ?: 'N/A';
$task_hours = get_post_meta($task_id, 'task_hours', true) ?: 'N/A';
$task_category = get_post_meta($task_id, 'task_category', true);
$task_label = get_post_meta($task_id, 'task_label', true);
$task_email = get_post_meta($task_id, 'task_email', true);
$task_date_needed = get_post_meta($task_id, 'task_date_needed', true);
$task_attachment = get_post_meta($task_id, 'task_attachment', true);
$attachment_url = $task_attachment ? wp_get_attachment_url($task_attachment) : '';
 $wp_page_message = get_option('wprabbit_page_restrict_message');
 $wprabbit_single_task_message = get_option('wprabbit_single_task_message');
 $task_admin_notes = get_post_meta($task_id, 'task_admin_notes', true);
$is_admin = current_user_can('manage_options');
$is_task_owner = ($current_user_id === intval($task_author_id));



get_header();
?>
<div class="single-task">
<div class="task-container">
    <?php if ($is_admin || $is_task_owner) : ?>
    <div class="col">
    <h1 class="mb-3 single-header">Your Task</h1>
    <h3 class="mb-3"><?php echo esc_html($task_title); ?></h3>
    <p class="small"><strong>Description:</strong> <?php echo esc_html($task_description); ?></p>
    <p class="small"><strong>Category:</strong> <?php echo esc_html($task_category); ?></p>
    <p class="small"><strong>Urgency:</strong> <?php echo esc_html($task_label); ?></p>
    <p class="small"><strong>Needed By:</strong> <?php echo esc_html($task_date_needed); ?></p>
		    <p class="small cost-hr"><strong>Cost:</strong> £<?php echo esc_html($task_cost); ?></p>
    <p class="small cost-hr"><strong>Est Hours:</strong> <?php echo esc_html($task_hours); ?> hours</p>
     <p class="small mt-2 mb-5"><strong>Status:</strong> <span class="task-status-<?php echo strtolower($task_status); ?>"><?php echo esc_html($task_status); ?></span></p>
     <?php if ($task_status == 'Pending Approval') : ?>
        <button class="approve-task-button btn btn-lg btn-secondary" data-task-id="<?php echo esc_attr($task_id); ?>" data-nonce="<?php echo wp_create_nonce('wprabbit_task_approval_nonce'); ?>">
            Approve Task
        </button>
        <p class="approval-message" style="display: none; color: green;">Task approved!</p>
    <?php endif; ?>
    </div>
    
        <?php if (!empty($task_admin_notes)) : ?>
         <div class="col">
            <div class="admin-notes">
                <h1 class="single-header mb-3 ">Task Notes</h1>
                <p class="small"><?php echo nl2br(esc_html($task_admin_notes)); ?></p>
            </div>
             </div>
        <?php endif; ?>
       

    <?php if ($attachment_url) : ?>
        <p><strong>Attachment:</strong> <a href="<?php echo esc_url($attachment_url); ?>" download>Download</a></p>
    <?php endif; ?>
    
 
     <?php else : ?>
        <div class="unauthorized-message">
             <h1 class="mb-3 single-header"><?php echo esc_html($wp_page_message); ?></h1>
            <h2>🚫 Restricted Access</h2>
            <p><?php echo esc_html($wprabbit_single_task_message); ?></p>
            <a class="btn mb-5 p-2 btn-sm btn-secondary" href="<?php echo home_url('/contact'); ?>">Contact Support</a>
            <a href="<?php echo home_url('/tasks'); ?>" class="button">View All Tasks</a>
        </div>
    <?php endif; ?>
</div>
</div>
<?php get_footer(); ?>
