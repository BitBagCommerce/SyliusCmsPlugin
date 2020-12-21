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
