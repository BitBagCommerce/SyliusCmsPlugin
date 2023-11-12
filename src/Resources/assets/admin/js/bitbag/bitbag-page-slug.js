/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

import triggerCustomEvent from '../../../common/js/utilities/triggerCustomEvent';

export class HandleSlugUpdate {
    constructor(
        config = {
            wrappersIndicator: 'data-bb-cms-wrapper',
            lockFieldIndicator: 'data-bb-cms-toggle-slug',
            bbTarget: 'bitbag_sylius_cms_plugin_page',
        }
    ) {
        this.wrappers = document.querySelectorAll(`[${config.wrappersIndicator}]`);
        this.lockFieldIndicator = `[${config.lockFieldIndicator}]`;
        this.bbTarget = config.bbTarget;
        this.config = config;
    }

    init() {
        if (typeof this.config !== 'object') {
            throw new Error('Bitbag CMS Plugin - HandleSlugUpdate class config is not a valid object');
        }

        if (typeof this.lockFieldIndicator !== 'string' || typeof this.bbTarget !== 'string') {
            throw new Error('Bitbag CMS Plugin - HandleSlugUpdate class config key values are not valid strings');
        }

        this._handleFields();
    }

    _handleFields() {
        this.wrappers.forEach((item) => {
            const locale = item.dataset.locale;
            const textField = item.querySelector(`#${this.bbTarget}_translations_${locale}_name`);
            const slugField = item.querySelector(`#${this.bbTarget}_translations_${locale}_slug`);
            const lockField = item.querySelector(this.lockFieldIndicator);

            if (!textField || !slugField || !locale) {
                return;
            }

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
            console.error(`BitBag CMS Plugin - HandleSlugUpdate class error : ${error}`);
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
