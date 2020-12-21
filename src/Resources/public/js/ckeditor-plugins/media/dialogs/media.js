CKEDITOR.dialog.add('mediaDialog', editor => ({
    title: 'Insert products',
    minWidth: 400,
    minHeight: 200,
    contents: [
        {
            id: 'tab-basic',
            label: 'Basic Settings',
            elements: [
                {
                    type: 'text',
                    id: 'taxon-code',
                    label: 'Taxon code',
                    'default': '',
                    validate: CKEDITOR.dialog.validate.notEmpty('Taxon code field cannot be empty.'),
                },
                {
                    type: 'text',
                    id: 'header',
                    label: 'Header',
                    'default': '',
                    validate: CKEDITOR.dialog.validate.notEmpty('Header field cannot be empty.'),
                },
                {
                    type: 'text',
                    id: 'limit',
                    label: 'Limit',
                    'default': 4,
                    validate: CKEDITOR.dialog.validate.notEmpty('Limit field cannot be empty.'),
                },
            ],
        },
    ],
    onOk() {
        const dialog = this;

        editor.insertHtml(`{{ app_cms_render_products('${dialog.getValueOf('tab-basic', 'taxon-code')}', '${dialog.getValueOf('tab-basic', 'header')}', ${dialog.getValueOf('tab-basic', 'limit')}) }}`);
    },
}));
