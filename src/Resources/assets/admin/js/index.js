import {HandleCsvUpload, HandleSlugUpdate, HandlePreview, HandleAutoComplete} from './bitbag';
import trix from './bitbag/bitbag-trix-editor';

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
