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
