/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

CKEDITOR.plugins.add('mediaVideo', {
    icons: 'mediavideo',
    init(editor) {
        editor.addCommand('mediaVideo', new CKEDITOR.dialogCommand('videoDialog'));
        editor.ui.addButton('MediaVideo', {
            label: 'Insert media video',
            command: 'mediaVideo',
            toolbar: 'insert',
        });
        CKEDITOR.dialog.add('videoDialog', `${this.path.replace('video/', '')}dialogs/index.js`);
    },
});
