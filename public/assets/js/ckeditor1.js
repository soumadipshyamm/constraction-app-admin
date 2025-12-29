import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

// Replace 'editor' with the ID of your textarea element
const editor = document.querySelector('#editor');

ClassicEditor.create(editor)
    .then(editor => {
        console.log('Editor was initialized', editor);
    })
    .catch(error => {
        console.error(error.stack);
    });
