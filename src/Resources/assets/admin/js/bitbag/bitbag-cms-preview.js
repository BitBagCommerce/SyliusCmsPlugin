/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

export class HandlePreview {
    constructor(
        config = {
            previewButton: 'data-bb-cms-preview-btn',
            previewModal: 'data-bb-cms-preview-modal',
            channelSwitch: 'data-bb-cms-channel',
            localeSwitch: 'data-bb-cms-locale',
        }
    ) {
        this.config = config;
        this.button = document.querySelector(`[${config.previewButton}]`);
        this.modal = document.querySelector(`[${config.previewModal}]`);
        this.modalSelector = config.previewModal;
        this.channelSelector = config.channelSwitch;
        this.localeSelector = config.localeSwitch;
    }
    init() {
        if (typeof this.config !== 'object') {
            throw new Error('Bitbag CMS Plugin - HandlePreview class config is not a valid object');
        }
        if (
            typeof this.localeSelector !== 'string' ||
            typeof this.channelSelector !== 'string' ||
            typeof this.modalSelector !== 'string'
        ) {
            throw new Error('Bitbag CMS Plugin - HandlePreview class config key values are not valid strings');
        }
        this._resourcePreview();
    }

    _$_CKEDITOR_MODAL_SHOW() {
        const root = $(`[${this.modalSelector}]`);
        return root.modal('show');
    }

    _$_CKEDITOR_UPDATE_INSTANCES() {
        [...CKEDITOR.instances].forEach((instance) => instance.updateElement());
    }

    _resourcePreview() {
        this.button.addEventListener('click', (e) => {
            e.preventDefault();

            this._$_CKEDITOR_UPDATE_INSTANCES;
            this._createPreview();
            this._$_CKEDITOR_MODAL_SHOW();
        });
    }

    async _createPreview() {
        this.modal.querySelector('.ui.loadable').classList.add('loading');
        this.modal.disabled = true;

        const channelCode = document.querySelector(`[${this.channelSelector}]`).value;
        const localeCode = document.querySelector(`[${this.localeSelector}]`).value;
        const path = this.button.dataset.url;
        const form = this.button.closest('form');

        const settings = {
            method: 'POST',
            body: new FormData(form),
        };

        try {
            const req = await fetch(`${path}?_channel_code=${channelCode}&_locale=${localeCode}`, settings);
            const res = await req.text();

            const blob = new Blob([res], {type: 'text/html', charset: 'utf-8'});
            const blobUrl = window.URL.createObjectURL(blob);

            this.modal.querySelector('iframe').src = blobUrl;
        } catch (error) {
            console.log(error);
        } finally {
            this.modal.querySelector('.ui.loadable').classList.remove('loading');
            this.modal.disabled = false;
        }
    }
}

export default HandlePreview;
