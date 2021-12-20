/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

CKEDITOR.plugins.add('mediaImage', {
    icons: 'mediaimage',
    init(editor) {
        editor.addCommand('mediaImage', new CKEDITOR.dialogCommand('imageDialog'));
        editor.ui.addButton('MediaImage', {
            label: 'Insert media image',
            command: 'mediaImage',
            toolbar: 'insert',
        });
        CKEDITOR.dialog.add('imageDialog', `${this.path.replace('image/', '')}dialogs/index.js`);
    },
});
