jQuery(document).ready(function ($) {
    $('.task-status-dropdown').on('change', function () {
        var taskId = $(this).data('task-id');
        var newStatus = $(this).val();
        var statusUpdated = $(this).next('.task-status-updated');

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'wprabbit_update_task_status',
                task_id: taskId,
                new_status: newStatus
            },
            success: function (response) {
                if (response.success) {
                    statusUpdated.show().delay(1000).fadeOut();
                } else {
                    alert('Failed to update task.');
                }
            },
            error: function () {
                alert('Error updating task.');
            }
        });
    });
});
