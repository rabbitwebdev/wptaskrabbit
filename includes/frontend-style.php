<?php
if (!defined('ABSPATH')) {
    exit;
}

// Inject Custom Styles into the Frontend
add_action('wp_head', function () {
    $bg_color = get_option('wprabbit_form_bg_color', '#ffffff');
    $text_color = get_option('wprabbit_form_text_color', '#000000');
    $button_color = get_option('wprabbit_form_button_color', '#0073aa');
    $border_radius = get_option('wprabbit_form_border_radius', '5');
    $input_radius = get_option('wprabbit_form_input_radius', '2');
    $text_size = get_option('wprabbit_form_text_size', '12');
    
    echo "<style>
    /* Default 1-Column Layout */
#wprabbit-task-form-container.one-column {
    width: 100%;
}
#wprabbit-task-form-container.one-column .form-group {
    width: 100%;
    margin-bottom: 15px;
}

/* 2-Column Layout */
#wprabbit-task-form-container.two-column .wprabbit-task-form {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}
#wprabbit-task-form-container.two-column .wprabbit-task-form p.task-field {
    width: 48%;
    margin-bottom: 15px;
}
#wprabbit-task-form-container.two-column .wprabbit-task-form .btn {
    width: 100%;
}
#wprabbit-task-form-container.two-column .wprabbit-task-form .task-fieltext {
  width: 100%;
}
@media only screen and (max-width: 600px) {
       #wprabbit-task-form-container.two-column .wprabbit-task-form p.task-field {
    width: 100%;
    margin-bottom: 15px;
}
} 


        .wprabbit-task-form {
            background-color: $bg_color;
            color: $text_color;
            font-size:{$text_size}px;
            padding: 15px;
            border-radius: {$border_radius}px;
            border: 1px solid #ddd;
        }
        
        .wprabbit-task-table {
            background-color: $bg_color;
            color: $text_color;
            font-size:{$text_size}px;
            padding: 15px;
            border-radius: {$border_radius}px;
            border: 1px solid #ddd;
            width:100%;
        }
        
        .wprabbit-task-table td {
        border-bottom: 1px solid $text_color;
         font-size:{$text_size}px;
         padding:5px;
        }
        
        .wprabbit-task-table th {
        border-bottom: 2px solid $text_color;
         font-size:{$text_size}px;
         padding:8px 5px;
        }
        

        .wprabbit-task-form .inputs {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: {$input_radius}px;
            border: 1px solid #ccc;
        }

        .wprabbit-task-form button {
            background-color: $button_color;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: {$input_radius}px;
            transition: 500ms;
        }

        .wprabbit-task-form button:hover {
            opacity: 0.8;
            transition: 500ms;
        }
    </style>";
});
