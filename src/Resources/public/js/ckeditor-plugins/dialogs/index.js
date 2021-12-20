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
    else return 'Empty name';
}

function insertHtml(data) {
    const output = data
        .map(
            (media) =>
                `<div class="media-list__item">
          <label for="${media.code}" class="media-list__item__label"><strong>${trimValue(
                    htmlToString(checkName(media.name))
                )}</strong></strong> (${trimValue(media.code)})</label>
          <input image-path="${media.path}" class="media-list__item__input" type="radio" name="media" value="${
                    media.code
                }">
          <img class="media-list__item__img" src="${media.path}"/>
        </div>`
        )
        .join('');
    return output;
}

function numPages(totalResults) {
    return Math.ceil(totalResults / limit);
}

function prevImagesPage() {
    if (currentPage > 1) {
        currentPage--;
        changePage(currentPage);
    }
    showMediaImages(phrase, currentPage);
}

function nextImagesPage() {
    if (currentPage < totalPages) {
        currentPage++;
        changePage(currentPage);
    }
    showMediaImages(phrase, currentPage);
}

function prevVideosPage() {
    if (currentPage > 1) {
        currentPage--;
        changePage(currentPage);
    }
    refreshMediaVideos();
}

function nextVideosPage() {
    if (currentPage < totalPages) {
        currentPage++;
        changePage(currentPage);
    }
    refreshMediaVideos();
}

function changePage(page) {
    const btn_next = document.getElementById('btn-next');
    const btn_prev = document.getElementById('btn-prev');
    const pageNumber = document.getElementById('page-number');

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
        url: route + '?' + shallowDecoded,
        dataType: 'JSON',
        success(data) {
            totalPages = numPages(data.total);
            changePage(currentPage);
            const element = CKEDITOR.document.getById('media-list');
            if (element) {
                element.setHtml(insertHtml(data._embedded.items));
            }
        },
        error(jqXHR, textStatus, errorThrown) {
            console.log(`ajax error ${textStatus} ${errorThrown}`);
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
        url: route + '?' + shallowDecoded,
        dataType: 'JSON',
        success(data) {
            totalPages = numPages(data.total);
            changePage(currentPage);
            const element = CKEDITOR.document.getById('media-list');
            if (element) {
                element.setHtml(insertHtml(data._embedded.items));
            }
        },
        error(jqXHR, textStatus, errorThrown) {
            console.log(`ajax error ${textStatus} ${errorThrown}`);
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
            id: 'media-content',
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
                        changePage(currentPage);
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
                    id: 'media-list',
                    label: 'Media found:',
                    html: '<form class="media-list" id="media-list"></form>',
                },
                {
                    type: 'hbox',
                    widths: ['25%', '25%', '25%'],
                    style: 'width: 10em',
                    align: 'center',
                    children: [
                        {
                            type: 'html',
                            id: 'btn-prev',
                            html: '<button class="btn" id="btn-prev" onclick="prevVideosPage()">&lsaquo;</button>',
                        },
                        {
                            type: 'html',
                            id: 'page-number',
                            html: '<span class="page-number" id="page-number"></span>',
                        },
                        {
                            type: 'html',
                            id: 'btn-next',
                            html: '<button class="btn" id="btn-next" onclick="nextVideosPage()">&rsaquo;</button>',
                        },
                    ],
                },
            ],
        },
    ],
    onOk() {
        const dialog = this;
        const document = CKEDITOR.document;
        const element = document.find('.media-list__item__input:checked');
        const imagePath = element.getItem(0).getAttribute('image-path');
        const imageWidth = dialog.getContentElement('media-content', 'imageWidth').getValue();
        const imageHeight = dialog.getContentElement('media-content', 'imageHeight').getValue();

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
            id: 'media-content',
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
                        changePage(currentPage);
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
                    id: 'media-list',
                    label: 'Media found:',
                    html: '<form class="media-list" id="media-list"></form>',
                },
                {
                    type: 'hbox',
                    widths: ['25%', '25%', '25%'],
                    style: 'width: 10em',
                    align: 'center',
                    children: [
                        {
                            type: 'html',
                            id: 'btn-prev',
                            html: '<button class="btn" id="btn-prev" onclick="prevImagesPage()">&lsaquo;</button>',
                        },
                        {
                            type: 'html',
                            id: 'page-number',
                            html: '<span class="page-number" id="page-number"></span>',
                        },
                        {
                            type: 'html',
                            id: 'btn-next',
                            html: '<button class="btn" id="btn-next" onclick="nextImagesPage()">&rsaquo;</button>',
                        },
                    ],
                },
            ],
        },
    ],
    onOk() {
        const dialog = this;
        const document = CKEDITOR.document;
        const element = document.find('.media-list__item__input:checked');
        const imagePath = element.getItem(0).getAttribute('image-path');
        const imageWidth = dialog.getContentElement('media-content', 'imageWidth').getValue();
        const imageHeight = dialog.getContentElement('media-content', 'imageHeight').getValue();

        editor.insertHtml(
            `<img src="${imagePath}" alt="cms plugin media image" style="height:${imageHeight}px; width:${imageWidth}px"/>`
        );
    },
}));
