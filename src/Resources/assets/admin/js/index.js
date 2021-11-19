import './bitbag-media-autocomplete';
// import './bitbag-cms-resource-preview';
import {HandleCsvUpload, HandleSlugUpdate, HandlePreview} from './bitbag';

new HandleCsvUpload().init();

new HandleSlugUpdate().init();

new HandlePreview().init();
