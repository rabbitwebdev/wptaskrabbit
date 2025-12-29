const { registerBlockType } = wp.blocks;
const { RichText, InspectorControls } = wp.blockEditor;
const { PanelBody, ToggleControl, TextControl, SelectControl } = wp.components;
const { __ } = wp.i18n;

import Edit from './edit';
import save from './save';
import './style.css';

registerBlockType('wprabbit/task-form', {
    edit: Edit,
    save,
});
registerBlockType('wprabbit/task-form', {
    title: 'Task Form',
    icon: 'schedule',
    category: 'widgets',
    attributes: {
        content: {
            type: 'string',
            source: 'html',
            selector: 'p',
        },
        className: {
            type: 'string',
            default: 'task-form',
        },
    },
    supports: {
        html: false,
    },
    edit: () => {
        return (
            wp.element.createElement('p', {}, 'Task Form block (new block) Tailwind.')
        );
    },
    save: () => {
        // Important: Must return null for server-side render
        return null;
    },
});