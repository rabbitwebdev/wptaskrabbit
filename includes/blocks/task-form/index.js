import Edit from './edit';
import save from './save';
import './style.css';

registerBlockType('wprabbit/task-form', {
    edit: Edit,
    save,
});
