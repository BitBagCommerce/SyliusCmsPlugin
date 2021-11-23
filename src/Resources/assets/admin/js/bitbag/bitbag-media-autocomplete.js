/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

export class HandleAutoComplete {
    constructor(
        config = {
            choiceName: 'data-bb-cms-choice-name',
            choiceValue: 'data-bb-cms-choice-value',
            criteriaType: 'data-bb-cms-criteria-type',
            criteriaName: 'data-bb-cms-criteria-name',
            editUrl: 'data-bb-cms-load-edit-url',
            nameMessage: 'data-bb-cms-name-message',
            deleteButton: 'data-bb-cms-delete-selected',
            choosenPreview: 'data-bb-cms-selected-image',
            selectionMenu: 'data-bb-cms-selection-menu',
            selectInput: 'data-bb-cms-image-select',
        }
    ) {
        this.config = config;
        this.HTMLChars = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
        };
    }

    init() {
        if (typeof this.config !== 'object') {
            throw new Error('Bitbag CMS Plugin - HandleAutoComplete class config is not a valid object');
        }
        this._mediaAutoComplete();
    }

    _htmlToString(item) {
        return String(item).replace(/&|<|>|"/gi, function (matched) {
            return HTMLChars[matched];
        });
    }

    _trimValue(item) {
        return item.length > mediaCharLimit ? item.substring(0, mediaCharLimit) + '...' : item;
    }

    _optionNameTmpl(item, nameField, defaultName) {
        return '\n    <img src="'
            .concat(item.path, ' " alt="media-img" />\n    <strong> ')
            .concat(
                !item[nameField] ? defaultName : trimValue(this._htmlToString(item[nameField])),
                ' </strong>\n    ('
            )
            .concat(this._trimValue(item.code), ')\n');
    }

    _mediaAutoComplete() {}

    async _getMediaImages() {
        try {
            const res = await fetch();
            const data = res.json();
            return data;
        } catch (error) {}
    }

    // _createDropdownFromElement(element) {
    //     var values = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];
    //     element.dropdown({
    //         delay: {
    //             search: 250,
    //         },
    //         values: values,
    //         forceSelection: false,
    //         onChange: function () {
    //             imageDelete.removeClass('is-hidden');
    //         },
    //         apiSettings: {
    //             dataType: 'JSON',
    //             cache: false,
    //             beforeSend: function beforeSend(settings) {
    //                 settings.data.limit = 30;
    //                 settings.data.criteria = {
    //                     search: {
    //                         type: 'contains',
    //                         value: settings.urlData.query,
    //                     },
    //                     type: 'image',
    //                 };
    //                 return settings;
    //             },
    //             onResponse: function onResponse(response) {
    //                 return {
    //                     success: true,
    //                     results: response._embedded.items.map(function (item) {
    //                         return {
    //                             name: this_optionNameTmpl(item, choiceName, nameMessage),
    //                             value: item[choiceValue],
    //                         };
    //                     }),
    //                 };
    //             },
    //         },
    //     });
    // }

    // _mediaAutoComplete() {
    //     $('.bitbag-media-autocomplete').each(function (idx, el) {
    //         var element = $(el);
    //         var _el$dataset = el.dataset,
    //             choiceName = _el$dataset.choiceName,
    //             choiceValue = _el$dataset.choiceValue,
    //             loadEditUrl = _el$dataset.loadEditUrl,
    //             nameMessage = _el$dataset.nameMessage;
    //         var imageDelete = element.find('.js-image-delete'),
    //             selectedImage = element.find('.js-selected-image'),
    //             autocompleteInput = element.find('input.autocomplete');
    //         var autocompleteValue = element.find('input.autocomplete').val();
    //         var autocompleteTextValues = autocompleteValue.split(',').filter(String);

    //         if (autocompleteTextValues.length > 0) {
    //             var menuElement = element.find('div.menu');
    //             menuElement.api({
    //                 on: 'now',
    //                 method: 'GET',
    //                 url: loadEditUrl,
    //                 beforeSend: function beforeSend(settings) {
    //                     /* eslint-disable-next-line no-param-reassign */
    //                     settings.data[choiceValue] = autocompleteTextValues;
    //                     return settings;
    //                 },
    //                 onSuccess: function onSuccess(response) {
    //                     response.forEach(function (item) {
    //                         this._createDropdownFromElement(element, [
    //                             {
    //                                 name: this._optionNameTmpl(item, choiceName, nameMessage),
    //                                 value: item.code,
    //                                 selected: true,
    //                             },
    //                         ]);
    //                         menuElement.append(
    //                             $('<div class="item" data-value="'.concat(item[choiceValue], '"></div>'))
    //                         );
    //                     });
    //                 },
    //             });
    //         } else {
    //             console.log(element);
    //             this._createDropdownFromElement(element);
    //         }

    //         if (imageDelete.length) {
    //             if (autocompleteTextValues.length) {
    //                 imageDelete.removeClass('is-hidden');
    //             }
    //             imageDelete.on('click', () => {
    //                 imageDelete.addClass('is-hidden');
    //                 autocompleteInput.val('');
    //                 selectedImage.html('');
    //             });
    //         }
    //     });
    // }
}

export default HandleAutoComplete;
