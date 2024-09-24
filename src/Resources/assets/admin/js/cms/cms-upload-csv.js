export class HandleCsvUpload {
    constructor(config = {textField: 'data-bb-cms-text', fileField: 'data-bb-cms-file'}) {
        this.config = config;
        this.textField = document.querySelector(`[${config.textField}]`);
        this.fileField = document.querySelector(`[${config.fileField}]`);
    }

    init() {
        if (typeof this.config !== 'object') {
            throw new Error('Sylius CMS Plugin - HandleCsvUpload class config is not a valid object');
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
