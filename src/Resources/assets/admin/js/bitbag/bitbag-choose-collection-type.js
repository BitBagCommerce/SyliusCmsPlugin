

export class HandleChooseCollectionType {
    init() {
        window.addEventListener('DOMContentLoaded', () => {
            const typeField = document.getElementById('sylius_cms_plugin_collection_type');
            const fields = {
                page: document.getElementById('collection-type-pages'),
                block: document.getElementById('collection-type-blocks'),
                media: document.getElementById('collection-type-media')
            };

            const hideAllFields = () => {
                Object.values(fields).forEach(field => field.style.display = 'none');
            };

            const showField = (type) => {
                hideAllFields();
                if (fields[type]) {
                    fields[type].style.display = 'block';
                }
            };

            showField(typeField.value);

            typeField.addEventListener('change', (event) => {
                showField(event.target.value);
            });
        });
    }
}
