<?php
if (!defined('ABSPATH')) {
    exit;
}

function wprabbit_handle_file_upload($file, $post_id) {
    $upload_result = wp_handle_upload($file, array('test_form' => false));
    if (isset($upload_result['file'])) {
        $attachment_id = wp_insert_attachment(array(
            'post_mime_type' => $upload_result['type'],
            'post_title'     => sanitize_file_name($file['name']),
            'post_status'    => 'inherit'
        ), $upload_result['file'], $post_id);
        
        require_once ABSPATH . 'wp-admin/includes/image.php';
        wp_generate_attachment_metadata($attachment_id, $upload_result['file']);
        return $attachment_id;
    }
    return false;
}
