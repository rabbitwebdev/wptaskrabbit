import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
    return (
        <div {...useBlockProps()}>
            <div className="task-form-preview">
                <p>{__('Task Submission Form will appear here.', 'wp-rabbit-dev')}</p>
            </div>
        </div>
    );
}
