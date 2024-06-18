/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

export class HandleChooseSectionType {
    init() {
        window.addEventListener('DOMContentLoaded', () => {
            const typeField = document.getElementById('bitbag_sylius_cms_plugin_section_type');
            const fields = {
                page: document.getElementById('section-type-pages'),
                block: document.getElementById('section-type-blocks'),
                media: document.getElementById('section-type-media')
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
