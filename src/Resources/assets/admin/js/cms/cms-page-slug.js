import triggerCustomEvent from '../../../common/js/utilities/triggerCustomEvent';

export class HandleSlugUpdate {
    constructor(
        config = {
            wrappersIndicator: 'data-bb-cms-wrapper',
            lockFieldIndicator: 'data-bb-cms-toggle-slug',
            bbTarget: 'sylius_cms_page',
            nameField: 'sylius_cms_page_name',
        }
    ) {
        this.wrappers = document.querySelectorAll(`[${config.wrappersIndicator}]`);
        this.lockFieldIndicator = `[${config.lockFieldIndicator}]`;
        this.bbTarget = config.bbTarget;
        this.config = config;
        this.nameField = document.getElementById(`${config.nameField}`);
    }

    init() {
        if (typeof this.config !== 'object') {
            throw new Error('Sylius CMS Plugin - HandleSlugUpdate class config is not a valid object');
        }

        if (typeof this.lockFieldIndicator !== 'string' || typeof this.bbTarget !== 'string') {
            throw new Error('Sylius CMS Plugin - HandleSlugUpdate class config key values are not valid strings');
        }

        if (!this.nameField ) {
            throw new Error('Sylius CMS Plugin - HandleSlugUpdate name field not found');
        }

        this._handleFields();
    }

    _handleFields() {
        this.wrappers.forEach((item) => {
            const locale = item.dataset.locale;

            let slugField = item.querySelector(`#${this.bbTarget}_translations_${locale}_slug`);
            if (!slugField) {
                slugField = item.querySelector(`#${this.bbTarget}_slug`);
            }

            if (!slugField) {
                return;
            }

            let timeout;

            this.nameField.addEventListener('input', (e) => {
                e.preventDefault();

                if (!slugField.readOnly) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        this._updateSlug(slugField, this.nameField.value);
                    }, 1000);
                }
            });

            const lockField = item.querySelector(this.lockFieldIndicator);
            if (!lockField) {
                return;
            }

            lockField.addEventListener('click', (e) => {
                e.preventDefault();
                this._toggleSlugModification(slugField, lockField);
            });
        });
    }

    async _updateSlug(slugField, value) {
        triggerCustomEvent(slugField, 'cms.slug.update.start');
        slugField.parentNode.classList.add('loading');
        slugField.value = await this._getValidSlug(slugField.dataset.url, value);
        slugField.parentNode.classList.remove('loading');
        triggerCustomEvent(slugField, 'cms.slug.update.end');
    }

    async _getValidSlug(url, value) {
        try {
            const request = await fetch(`${url}?name=${encodeURIComponent(value)}`);
            const response = await request.json();
            return response.slug;
        } catch (error) {
            console.error(`Sylius CMS Plugin - HandleSlugUpdate class error : ${error}`);
        }
    }

    _toggleSlugModification(readOnlyEl, toggler) {
        readOnlyEl.readOnly = !readOnlyEl.readOnly;

        const icon = toggler.querySelector('i');
        icon.classList.toggle('lock');
        icon.classList.toggle('unlock');
    }
}

export default HandleSlugUpdate;
