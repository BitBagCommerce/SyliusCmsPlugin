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
    this.mediaContainers = document.querySelectorAll(`[${config.bbMediaContainer}]`);
    this.deleteButton = `[${config.deleteButton}]`;
    this.selectMenu = `[${config.selectMenu}]`;
    this.selectInput = `[${config.selectInput}]`;
    this.placeholder = `[${config.placeholder}]`;
  }

  init() {
    if (typeof this.config !== 'object') {
      throw new Error('Bitbag CMS Plugin - HandleAutoComplete class config is not a valid object');
    }
    this.mediaContainers.forEach((mediaContainer) => {
      this._handleSavedValue(mediaContainer);
      this._handleImageChoice(mediaContainer);
      this._handleResetBtn(mediaContainer);
    });
  }

  _handleResetBtn(mediaContainer) {
    const deleteButton = mediaContainer.querySelector(this.deleteButton);

    if (mediaContainer.querySelector('input[type=hidden]').value === '') {
      deleteButton.classList.add('is-hidden');

      return;
    }

    deleteButton.classList.remove('is-hidden');
    deleteButton.addEventListener('click', () => {
      this._resetValues(mediaContainer);
    });
  }

  _handleImageChoice(mediaContainer) {
    let timeout;

    mediaContainer.querySelector(this.selectInput).addEventListener('click', (e) => {
      e.preventDefault();
      this._getMediaImages(mediaContainer);
    });

    mediaContainer.querySelector(this.selectInput).addEventListener('input', (e) => {
      e.preventDefault();
      clearTimeout(timeout);

      timeout = setTimeout(() => {
        this._getMediaImages(mediaContainer, e.target.value);
      }, 500);
    });

    mediaContainer.querySelector('input[type=hidden]').addEventListener('change', (e) => {
      e.preventDefault();
      this._handleResetBtn(mediaContainer);
    });
  }
  async _handleSavedValue(mediaContainer) {
    if (mediaContainer.querySelector('input[type=hidden]').value === '') {
      return;
    }

    const url = `${mediaContainer.dataset.bbCmsLoadEditUrl}?${
      mediaContainer
        .querySelector('input[type=hidden]')
        .value
        .split(',')
        .filter(String)
        .map(value => `code[]=${value}`)
        .join('&')
    }`;

    try {
      triggerCustomEvent(mediaContainer, 'cms.media.saved.reload.start');

      mediaContainer.classList.add('loading');
      const res = await fetch(url);
      const data = await res.json();

      this._addToSelectMenu(data, mediaContainer);
      let children = [];
      let selectedContainer = mediaContainer.querySelector(this.selectMenu);
      if (selectedContainer !== null) {
        children = selectedContainer.children;
      }
      for (let child of children) {
        child.click();
      }

      triggerCustomEvent(mediaContainer, 'cms.media.saved.reload.completed', data);
    } catch (error) {
      console.error(`BitBag CMS Plugin - HandleAutoComplete class error : ${error}`);
      triggerCustomEvent(mediaContainer, 'cms.media.saved.reload.error', error);
    } finally {
      mediaContainer.classList.remove('loading');
      triggerCustomEvent(mediaContainer, 'cms.media.saved.reload.end');
    }
  }

  async _getMediaImages(mediaContainer, value = false) {
    const path = mediaContainer.dataset.bbCmsUrl;
    const typeQuery = mediaContainer.dataset.bbCmsCriteriaType;
    const searchValue = value ? `&criteria[search][value]=${value}` : '';
    const url = `${path}&limit=${this.config.limit}&criteria[search][type]=${typeQuery}&criteria[search][value]=${searchValue}`;

    try {
      triggerCustomEvent(mediaContainer, 'cms.media.display.start');

      mediaContainer.classList.add('loading');
      const res = await fetch(url);
      const data = await res.json();
      const items = data._embedded.items;

      this._addToSelectMenu(items, mediaContainer);

      triggerCustomEvent(mediaContainer, 'cms.media.display.completed', data);
    } catch (error) {
      console.error(`BitBag CMS Plugin - HandleAutoComplete class error : ${error}`);
      triggerCustomEvent(mediaContainer, 'cms.media.display.error', error);
    } finally {
      mediaContainer.classList.remove('loading');
      triggerCustomEvent(mediaContainer, 'cms.media.display.end');
    }
  }

  _resetValues(mediaContainer) {
    triggerCustomEvent(mediaContainer, 'cms.media.reset.start');
    mediaContainer.querySelector('input[type=hidden]').value = '';
    mediaContainer.querySelector(this.selectMenu).innerHTML = '';
    mediaContainer.querySelector(this.placeholder).innerHTML = '';
    triggerCustomEvent(mediaContainer, 'cms.media.reset.end');
  }

  _addToSelectMenu(arr, mediaContainer) {
    triggerCustomEvent(mediaContainer, 'cms.media.display.update.start');
    const selectMenu = mediaContainer.querySelector(this.selectMenu);
    selectMenu.innerHTML = '';
    if (arr !== null) {
      arr.forEach((item) => {
        selectMenu.insertAdjacentHTML('beforeend', this._itemTemplate(item.path, item.code.trim()));
      });
    }
    triggerCustomEvent(mediaContainer, 'cms.media.display.update.end');
  }

  _itemTemplate(link, code) {
    return `<div class="item" data-value="${code}"><img src="${link}"/><strong>${code}</strong></div>`;
  }
}

export default HandleAutoComplete;
