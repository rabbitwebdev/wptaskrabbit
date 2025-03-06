import { useBlockProps } from '@wordpress/block-editor';

export default function save() {
    return (
        <div {...useBlockProps()}>
            <div className="wp-block-wprabbit-task-form">
                [wprabbit_task_form] {/* The shortcode is still used here */}
            </div>
        </div>
    );
}
