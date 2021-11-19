/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

export class HandleAutoComplete {
    constructor(config = {}) {
        this.config = config;
    }

    init() {
        if (typeof this.config !== 'object') {
            throw new Error('Bitbag CMS Plugin - HandlsAutoComplete class config is not a valid object');
        }
        // if () {
        //     return;
        // }
    }
}

export default HandleAutoComplete;
