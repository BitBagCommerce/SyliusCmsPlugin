/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

CKEDITOR.plugins.add('media', {
    icons: 'media',
    init(editor) {
        editor.addCommand('media', new CKEDITOR.dialogCommand('mediaDialog'));
        editor.ui.addButton('Media', {
            label: 'Insert media',
            command: 'media',
            toolbar: 'insert',
        });
        CKEDITOR.dialog.add('mediaDialog', `${this.path}dialogs/media.js`);
    },
});
