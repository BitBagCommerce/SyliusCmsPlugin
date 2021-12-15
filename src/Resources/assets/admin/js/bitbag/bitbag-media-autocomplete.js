/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/
import triggerCustomEvent from '../../../common/js/utilities/triggerCustomEvent';

export class HandleAutoComplete {
    constructor(
        config = {
            bbMediaContainer: 'data-bb-cms-autocomplete',
            choiceName: 'data-bb-cms-choice-name',
            choiceValue: 'data-bb-cms-choice-value',
            criteriaType: 'data-bb-cms-criteria-type',
            criteriaName: 'data-bb-cms-criteria-name',
            editUrl: 'data-bb-cms-load-edit-url',
            nameMessage: 'data-bb-cms-name-message',
            deleteButton: 'data-bb-cms-delete-selected',
            choosenPreview: 'data-bb-cms-selected-image',
            selectMenu: 'data-bb-cms-selection-menu',
            selectInput: 'data-bb-cms-image-select',
            placeholder: 'data-bb-cms-placeholder',
            limit: 30,
        }
    ) {
        this.config = config;
        this.mediaContainer = document.querySelector(`[${config.bbMediaContainer}]`);
        this.deleteButton = document.querySelector(`[${config.deleteButton}]`);
        this.selectMenu = document.querySelector(`[${config.selectMenu}]`);
        this.selectInput = document.querySelector(`[${config.selectInput}]`);
        this.placeholder = document.querySelector(`[${config.placeholder}]`);
        this.hiddenInput = this.mediaContainer.querySelector('input[type=hidden]');
    }

    init() {
        if (typeof this.config !== 'object') {
            throw new Error('Bitbag CMS Plugin - HandleAutoComplete class config is not a valid object');
        }
        this._handleSavedValue();
        this._handleImageChoice();
        this._handleResetBtn();
    }

    _handleResetBtn() {
        if (this.hiddenInput.value === '') {
            this.deleteButton.classList.add('is-hidden');
            return;
        }
        this.deleteButton.classList.remove('is-hidden');
        this.deleteButton.addEventListener('click', (e) => {
            this._resetValues();
        });
    }

    _handleImageChoice() {
        this.selectInput.addEventListener('click', (e) => {
            e.preventDefault();

            this._getMediaImages();
        });
        this.hiddenInput.addEventListener('change', (e) => {
            e.preventDefault();

            this._handleResetBtn();
        });
    }
    async _handleSavedValue() {
        if (this.hiddenInput.value === '') {
            return;
        }

        const url = `${this.mediaContainer.dataset.bbCmsLoadEditUrl}?code=${this.hiddenInput.value}`;

        try {
            triggerCustomEvent(this.mediaContainer, 'cms.media.saved.reload.start');

            this.mediaContainer.classList.add('loading');
            const res = await fetch(url);
            const data = await res.json();

            this._addToSelectMenu(data);
            this.selectMenu.firstChild.click();

            triggerCustomEvent(this.mediaContainer, 'cms.media.saved.reload.completed', data);
        } catch (error) {
            console.error(`BitBag CMS Plugin - HandleAutoComplete class error : ${error}`);
            triggerCustomEvent(this.mediaContainer, 'cms.media.saved.reload.error', error);
        } finally {
            this.mediaContainer.classList.remove('loading');
            triggerCustomEvent(this.mediaContainer, 'cms.media.saved.reload.end');
        }
    }

    async _getMediaImages() {
        const path = this.mediaContainer.dataset.bbCmsUrl;
        const typeQuery = this.mediaContainer.dataset.bbCmsCriteriaType;
        const url = `${path}&limit=${this.config.limit}&criteria[search][type]=${typeQuery}`;

        try {
            triggerCustomEvent(this.mediaContainer, 'cms.media.display.start');

            this.mediaContainer.classList.add('loading');
            const res = await fetch(url);
            const data = await res.json();
            const items = data._embedded.items;

            this._addToSelectMenu(items);

            triggerCustomEvent(this.mediaContainer, 'cms.media.display.completed', data);
        } catch (error) {
            console.error(`BitBag CMS Plugin - HandleAutoComplete class error : ${error}`);
            triggerCustomEvent(this.mediaContainer, 'cms.media.display.error', error);
        } finally {
            this.mediaContainer.classList.remove('loading');
            triggerCustomEvent(this.mediaContainer, 'cms.media.display.end');
        }
    }

    _resetValues() {
        triggerCustomEvent(this.mediaContainer, 'cms.media.reset.start');
        this.hiddenInput.value = '';
        this.selectMenu.innerHTML = '';
        this.placeholder.innerHTML = '';
        triggerCustomEvent(this.mediaContainer, 'cms.media.reset.end');
    }

    _addToSelectMenu(arr) {
        triggerCustomEvent(this.mediaContainer, 'cms.media.display.update.start');
        this.selectMenu.innerHTML = '';
        arr.forEach((item) => {
            this.selectMenu.insertAdjacentHTML('beforeend', this._itemTemplate(item.path, item.code.trim()));
        });
        triggerCustomEvent(this.mediaContainer, 'cms.media.display.update.end');
    }

    _itemTemplate(link, code) {
        return `<div class="item" data-value="${code}"><img src="${link}"/><strong>${code}</strong></div>`;
    }
}

export default HandleAutoComplete;
