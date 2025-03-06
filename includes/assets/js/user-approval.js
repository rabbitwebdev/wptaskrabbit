jQuery(document).ready(function ($) {
    $('.approve-task-button').on('click', function () {
        var taskId = $(this).data('task-id');
        var nonce = $(this).data('nonce');

        $.ajax({
            url: wprabbit_ajax.ajaxurl,
            type: 'POST',
            data: {
                action: 'wprabbit_user_approve_task',
                task_id: taskId,
                nonce: nonce
            },
            success: function (response) {
                if (response.success) {
                    alert('Task approved successfully!');
                    location.reload();
                } else {
                    alert('Error approving task.');
                }
            },
            error: function () {
                alert('Error processing request.');
            }
        });
    });
});
