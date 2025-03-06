jQuery(document).ready(function ($) {
    $('#wprabbit-task-form').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: wprabbit_ajax.ajaxurl,
            type: 'POST',
            data: {
                action: 'wprabbit_submit_task',
                nonce: $('#wprabbit_task_nonce_field').val(),
                task_name: $('input[name="task_name"]').val(),
                website_name: $('input[name="website_name"]').val(),
                 task_label: $('select[name="task_label"]').val(),
                  task_email: $('input[name="task_email"]').val(),
                  task_category: $('select[name="task_category"]').val(),
                   task_attachment: $('file[name="task_attachment"]').val(),
                  task_date_needed: $('input[name="task_date_needed"]').val(),
                task_description: $('textarea[name="task_description"]').val()
            },
            beforeSend: function () {
                $('#wprabbit-task-message').hide().text('');
            },
            success: function (response) {
                if (response.success) {
                    $('#wprabbit-task-form').hide();
                    $('#wprabbit-task-message').show().html('<p style="color: green;">' + response.data.message + '</p>');
                } else {
                    $('#wprabbit-task-message').show().html('<p style="color: red;">' + response.data.message + '</p>');
                }
            },
            error: function () {
                $('#wprabbit-task-message').show().html('<p style="color: red;">Something went wrong. Please try again.</p>');
            }
        });
    });
});
