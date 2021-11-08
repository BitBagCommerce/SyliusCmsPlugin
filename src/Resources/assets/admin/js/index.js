import './bitbag-block-image-preview';
import './bitbag-cms-resource-preview';
import './bitbag-media-autocomplete';
import {HandleCsvUpload, HandleSlugUpdate} from './bitbag';

new HandleCsvUpload().init();

new HandleSlugUpdate().init();
