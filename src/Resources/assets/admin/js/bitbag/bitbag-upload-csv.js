/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

export class HandleCsvUpload {
    constructor(config = {textField: 'data-bb-cms-text', fileField: 'data-bb-cms-file'}) {
        this.config = config;
        this.textField = document.querySelector(`[${config.textField}]`);
        this.fileField = document.querySelector(`[${config.fileField}]`);
    }

    init() {
        if (typeof this.config !== 'object') {
            throw new Error('Bitbag CMS Plugin - HandleCsvUpload class config is not a valid object');
        }

        this._handleFields();
    }

    _handleFields() {
        this._handleTextField();
        this._handleFileField();
    }

    _handleTextField() {
        this.textField.addEventListener('click', () => {
            this.fileField.click();
        });
    }

    _handleFileField() {
        this.fileField.addEventListener('change', (e) => {
            this.textField.value = e.target.files[0].name;
        });
    }
}

export default HandleCsvUpload;
