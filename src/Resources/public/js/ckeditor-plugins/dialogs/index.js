/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

let oldValue = null;
let phrase = '';
let currentPage = 1;
let totalPages = null;
let limit = 12;
const mediaCodeLength = 20;

function trimValue(item) {
    return item.length > mediaCodeLength ? item.substring(0, mediaCodeLength) + '...' : item;
}

function htmlToString(item) {
    return String(item).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function checkName(item) {
    if (item) return item;

    return 'Empty name';
}

function insertImageHtml(data) {
    const output = data
        .map((media) => {
            return `<div class="media-list__item">
          <label for="${media.code}" class="media-list__item__label"><strong>${trimValue(
                htmlToString(checkName(media.name))
            )}</strong> (${trimValue(media.code)})</label>
          <input image-path="${media.path}" class="media-list__item__input" type="radio" name="media" value="${
                media.code
            }">
          <img class="media-list__item__img" src="${media.path}"/>
        </div>`;
        })
        .join('');

    return output;
}

function insertVideoHtml(data) {
    const output = data
        .map((media) => {
            return `<div class="media-list__item">
          <label for="${media.code}" class="media-list__item__label"><strong>${trimValue(
                htmlToString(checkName(media.name))
            )}</strong> (${trimValue(media.code)})</label>
          <input image-path="${media.path}" class="media-list__item__input" type="radio" name="media" value="${
                media.code
            }">
          <video class="media-list__item__img" src="${media.path}"></video>
        </div>`;
        })
        .join('');

    return output;
}

function numPages(totalResults) {
    return Math.ceil(totalResults / limit);
}

function prevImagesPage() {
    if (currentPage > 1) {
        currentPage--;
        changePage(currentPage, 'image-btn-next', 'image-btn-prev', 'image-page-number');
    }

    showMediaImages(phrase, currentPage);
}

function nextImagesPage() {
    if (currentPage < totalPages) {
        currentPage++;
        changePage(currentPage, 'image-btn-next', 'image-btn-prev', 'image-page-number');
    }

    showMediaImages(phrase, currentPage);
}

function prevVideosPage() {
    if (currentPage > 1) {
        currentPage--;
        changePage(currentPage, 'video-btn-next', 'video-btn-prev', 'video-page-number');
    }

    showMediaVideos(phrase, currentPage);
}

function nextVideosPage() {
    if (currentPage < totalPages) {
        currentPage++;
        changePage(currentPage, 'video-btn-next', 'video-btn-prev', 'video-page-number');
    }

    showMediaVideos(phrase, currentPage);
}

function changePage(page, next, prev, number) {
    const btn_next = document.getElementById(next);
    const btn_prev = document.getElementById(prev);
    const pageNumber = document.getElementById(number);

    if (page < 1) page = 1;
    if (page > totalPages) page = totalPages;

    pageNumber.innerHTML = page;

    if (page == 1) {
        btn_prev.style.visibility = 'hidden';
    } else {
        btn_prev.style.visibility = 'visible';
    }

    if (page == totalPages) {
        btn_next.style.visibility = 'hidden';
    } else {
        btn_next.style.visibility = 'visible';
    }
}

function showMediaImages(phrase, pageNumber) {
    const myObject = {
        criteria: {
            search: {
                type: 'contains',
                value: phrase,
            },
            type: 'image',
        },
        page: pageNumber,
        limit: limit,
    };

    const shallowEncoded = $.param(myObject);
    const shallowDecoded = decodeURIComponent(shallowEncoded);

    $.ajax({
        type: 'GET',
        url: `${route}?${shallowDecoded}`,
        dataType: 'JSON',
        success(data) {
            totalPages = numPages(data.total);
            changePage(currentPage, 'image-btn-next', 'image-btn-prev', 'image-page-number');
            const element = CKEDITOR.document.getById('media-image-list');

            if (element) {
                element.setHtml(insertImageHtml(data._embedded.items));
            }
        },
        error(jqXHR, textStatus, errorThrown) {
            console.error(`ajax error ${textStatus} ${errorThrown}`);
        },
    });
}

function showMediaVideos(phrase, pageNumber) {
    const myObject = {
        criteria: {
            search: {
                type: 'contains',
                value: phrase,
            },
            type: 'video',
        },
        page: pageNumber,
        limit: limit,
    };

    const shallowEncoded = $.param(myObject);
    const shallowDecoded = decodeURIComponent(shallowEncoded);

    $.ajax({
        type: 'GET',
        url: `${route}?${shallowDecoded}`,
        dataType: 'JSON',
        success(data) {
            totalPages = numPages(data.total);
            changePage(currentPage, 'video-btn-next', 'video-btn-prev', 'video-page-number');
            const element = CKEDITOR.document.getById('media-video-list');

            if (element) {
                element.setHtml(insertVideoHtml(data._embedded.items));
            }
        },
        error(jqXHR, textStatus, errorThrown) {
            console.error(`ajax error ${textStatus} ${errorThrown}`);
        },
    });
}

CKEDITOR.dialog.add('videoDialog', (editor) => ({
    title: 'Choose media',
    minWidth: 1000,
    minHeight: 600,
    resizable: CKEDITOR.DIALOG_RESIZE_NONE,
    onShow() {
        phrase = '';
        showMediaVideos(phrase, currentPage);
    },

    contents: [
        {
            id: 'media-video-content',
            elements: [
                {
                    type: 'text',
                    id: 'phrase',
                    label: 'Search by phrase',
                    inputStyle: 'text-align: left',
                    controlStyle: 'width: 100%',
                    onKeyUp: function () {
                        phrase = this.getValue();

                        if (oldValue === phrase) {
                            return;
                        }

                        oldValue = this.getValue();
                        changePage(currentPage, 'video-btn-next', 'video-btn-prev', 'video-page-number');
                        showMediaVideos(phrase, currentPage);
                    },
                },
                {
                    type: 'hbox',
                    widths: ['25%', '25%'],
                    style: 'width: 10em',
                    align: 'left',
                    children: [
                        {
                            type: 'text',
                            id: 'imageWidth',
                            label: 'Image width',
                            inputStyle: 'text-align: center',
                            controlStyle: 'width: 4em',
                            inputStyle: 'width: 4em',
                        },
                        {
                            type: 'text',
                            id: 'imageHeight',
                            default: '200',
                            label: 'Image height',
                            inputStyle: 'text-align: center',
                            controlStyle: 'width: 4em',
                        },
                    ],
                },

                {
                    type: 'html',
                    id: 'media-video-list',
                    label: 'Media found:',
                    html: '<form class="media-list" id="media-video-list"></form>',
                },
                {
                    type: 'hbox',
                    widths: ['25%', '25%', '25%'],
                    style: 'width: 10em',
                    align: 'center',
                    children: [
                        {
                            type: 'html',
                            id: 'video-btn-prev',
                            html: '<button class="btn" id="video-btn-prev" onclick="prevVideosPage()">&lsaquo;</button>',
                        },
                        {
                            type: 'html',
                            id: 'video-page-number',
                            html: '<span class="page-number" id="video-page-number"></span>',
                        },
                        {
                            type: 'html',
                            id: 'video-btn-next',
                            html: '<button class="btn" id="video-btn-next" onclick="nextVideosPage()">&rsaquo;</button>',
                        },
                    ],
                },
            ],
        },
    ],
    onOk() {
        const dialog = this;
        const document = CKEDITOR.document;
        const element = document.find('#media-video-list .media-list__item__input:checked');
        const imagePath = element.getItem(0).getAttribute('image-path');
        const imageWidth = dialog.getContentElement('media-video-content', 'imageWidth').getValue();
        const imageHeight = dialog.getContentElement('media-video-content', 'imageHeight').getValue();

        editor.insertHtml(
            `<video src="${imagePath}" alt="cms plugin media video" style="height:${imageHeight}px; width:${imageWidth}px" controls></video>`
        );
    },
}));

CKEDITOR.dialog.add('imageDialog', (editor) => ({
    title: 'Choose media',
    minWidth: 1000,
    minHeight: 600,
    resizable: CKEDITOR.DIALOG_RESIZE_NONE,
    onShow() {
        phrase = '';
        showMediaImages(phrase, currentPage);
    },

    contents: [
        {
            id: 'media-image-content',
            elements: [
                {
                    type: 'text',
                    id: 'phrase',
                    label: 'Search by phrase',
                    inputStyle: 'text-align: left',
                    controlStyle: 'width: 100%',
                    onKeyUp: function () {
                        phrase = this.getValue();

                        if (oldValue === phrase) {
                            return;
                        }

                        oldValue = this.getValue();
                        changePage(currentPage, 'image-btn-next', 'image-btn-prev', 'image-page-number');
                        showMediaImages(phrase, currentPage);
                    },
                },
                {
                    type: 'hbox',
                    widths: ['25%', '25%'],
                    style: 'width: 10em',
                    align: 'left',
                    children: [
                        {
                            type: 'text',
                            id: 'imageWidth',
                            label: 'Image width',
                            inputStyle: 'text-align: center',
                            controlStyle: 'width: 4em',
                            inputStyle: 'width: 4em',
                        },
                        {
                            type: 'text',
                            id: 'imageHeight',
                            default: '200',
                            label: 'Image height',
                            inputStyle: 'text-align: center',
                            controlStyle: 'width: 4em',
                        },
                    ],
                },

                {
                    type: 'html',
                    id: 'media-image-list',
                    label: 'Media found:',
                    html: '<form class="media-list" id="media-image-list"></form>',
                },
                {
                    type: 'hbox',
                    widths: ['25%', '25%', '25%'],
                    style: 'width: 10em',
                    align: 'center',
                    children: [
                        {
                            type: 'html',
                            id: 'mage-btn-prev',
                            html: '<button class="btn" id="image-btn-prev" onclick="prevImagesPage()">&lsaquo;</button>',
                        },
                        {
                            type: 'html',
                            id: 'image-page-number',
                            html: '<span class="page-number" id="image-page-number"></span>',
                        },
                        {
                            type: 'html',
                            id: 'image-btn-next',
                            html: '<button class="btn" id="image-btn-next" onclick="nextImagesPage()">&rsaquo;</button>',
                        },
                    ],
                },
            ],
        },
    ],
    onOk() {
        const dialog = this;
        const document = CKEDITOR.document;
        const element = document.find('#media-image-list .media-list__item__input:checked');
        const imagePath = element.getItem(0).getAttribute('image-path');
        const imageWidth = dialog.getContentElement('media-image-content', 'imageWidth').getValue();
        const imageHeight = dialog.getContentElement('media-image-content', 'imageHeight').getValue();

        editor.insertHtml(
            `<img src="${imagePath}" alt="cms plugin media image" style="height:${imageHeight}px; width:${imageWidth}px"/>`
        );
    },
}));
