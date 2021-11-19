/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

export class HandlePreview {
    constructor(
        config = {
            previewButton: 'data-bb-preview-btn',
            previewModal: 'data-bb-preview-modal',
            channelSwitch: 'data-bb-channel',
            localeSwitch: 'data-bb-locale',
        }
    ) {
        this.button = document.querySelector(`[${config.previewButton}]`);
        this.modal = document.querySelector(`[${config.previewModal}]`);
        this.modalSelector = config.previewModal;
        this.channelSelector = config.channelSwitch;
        this.localeSelector = config.localeSwitch;
    }

    _$_CKEDITOR_MODAL_SHOW() {
        const root = $(`[${this.modalSelector}]`);
        return root.modal('show');
    }

    _resourcePreview() {
        this.button.addEventListener('click', (e) => {
            e.preventDefault();

            for (const instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

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
        }
    }

    init() {
        if (!this.button || !this.modal) {
            throw new Error('BitBag CMS Pugin - bitbag cms preview, couldnt retrieve correct nodes in the DOM');
        }
        this._resourcePreview();
    }
}

export default HandlePreview;
