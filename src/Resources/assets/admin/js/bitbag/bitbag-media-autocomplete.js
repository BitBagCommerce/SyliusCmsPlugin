/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

export class HandleAutoComplete {
    constructor(config = {}) {
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

    _createDropdownFromElement() {}

    _mediaAutoComplete() {}
}

export default HandleAutoComplete;
