import {HandleCsvUpload, HandleSlugUpdate, HandlePreview, HandleAutoComplete} from './bitbag';

if (document.querySelector('[data-bb-cms-text]') && document.querySelector('[data-bb-cms-file]')) {
    new HandleCsvUpload().init();
}

if (document.querySelectorAll('[data-bb-cms-wrapper]')?.length > 0) {
    new HandleSlugUpdate().init();
}

if (document.querySelector('[data-bb-cms-preview-btn]') && document.querySelector('[data-bb-cms-preview-modal]')) {
    new HandlePreview().init();
}

if (document.querySelector('[data-bb-cms-autocomplete]')) {
    new HandleAutoComplete().init();
}
