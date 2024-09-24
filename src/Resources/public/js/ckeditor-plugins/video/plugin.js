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
