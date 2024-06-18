import {HandleCsvUpload, HandleSlugUpdate, HandlePreview, HandleAutoComplete, HandleChooseSectionType} from './bitbag';

if (document.querySelector('[data-bb-target="cms-import"]')) {
    new HandleCsvUpload().init();
}

if (document.querySelectorAll('[data-bb-target="cms-slug-update"]').length > 0) {
    new HandleSlugUpdate().init();
}

if (document.querySelectorAll('[data-bb-cms-preview-btn]').length > 0) {
    new HandlePreview().init();
}

if (document.querySelector('[data-bb-target="cms-handle-autocomplete"]')) {
    new HandleAutoComplete().init();
}

if (document.querySelector('.section-type-items')) {
    new HandleChooseSectionType().init();
}
