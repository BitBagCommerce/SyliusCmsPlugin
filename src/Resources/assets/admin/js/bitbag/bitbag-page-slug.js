/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

export class HandleSlugUpdate {
    constructor(
        config = {
            wrappersIndicator: 'data-bb-wrapper',
            lockFieldIndicator: 'data-bb-toggle-slug',
            bbTarget: 'bitbag_sylius_cms_plugin_page',
        }
    ) {
        this.wrappers = document.querySelectorAll(`[${config.wrappersIndicator}]`);
        this.lockFieldIndicator = `[${config.lockFieldIndicator}]`;
        this.bbTarget = config.bbTarget;
    }

    init() {
        if (this.wrappers.length === 0) {
            throw new Error('Cms Plugin - Given selectors for handling slug update, are not valid');
        }
        this._handleFields();
    }

    _handleFields() {
        this.wrappers.forEach((item) => {
            const locale = item.dataset.locale;
            const textField = item.querySelector(`#${this.bbTarget}_translations_${locale}_name`);
            const slugField = item.querySelector(`#${this.bbTarget}_translations_${locale}_slug`);

            let timeout;

            textField.addEventListener('input', (e) => {
                e.preventDefault();
                if (slugField.readOnly) {
                    return;
                }
                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    this._updateSlug(slugField, textField.value);
                }, 1000);
            });
        });
    }

    async _updateSlug(slugField, value) {
        try {
            slugField.parentNode.classList.add('loading');

            slugField.value = await this._getValidSlug(slugField.dataset.url, value);
            slugField.parentNode.classList.remove('loading');
        } catch (error) {
            console.error(error);
        }
    }

    async _getValidSlug(url, value) {
        try {
            const request = await fetch(`${url}?name=${value}`);
            const response = await request.json();
            return response.slug;
        } catch (error) {
            console.error(error);
        }
    }
}

export default HandleSlugUpdate;
