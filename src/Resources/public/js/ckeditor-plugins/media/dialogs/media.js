let oldValue = null;
let phrase = '';
let current_page = 1;
let total_pages = null;
let limit = 5;

function insertHtml (data) {
    const output = data.map(media =>
        `<div class="media__item">
          <label for="${media.code}">${media.name}</label>
          <input image-path="${media.path}" class="mediaInput" type="radio" name="media" value="${media.code}">
          <img class="media" src=" ${media.path} "/>
        </div>`
    ).join('');
    return output;
}

function refreshMedia () {
    showMedia(phrase, current_page);
}

function numPages(totalResults){
    return Math.ceil(totalResults/limit);
}

function prevPage(){
    if (current_page > 1) {
        current_page--;
        changePage(current_page);
    }
    refreshMedia();

}

function nextPage(){
    if (current_page < total_pages) {
        current_page++;
        changePage(current_page);
    }
    refreshMedia();
}

function changePage(page)
{
    const btn_next = document.getElementById("btn_next");
    const btn_prev = document.getElementById("btn_prev");
    const pageNumber = document.getElementById("pageNumber");

    if (page < 1) page = 1;
    if (page > total_pages) page = total_pages;

    pageNumber.innerHTML = page;

    if (page == 1) {
        btn_prev.style.visibility = "hidden";
    } 
    else {
        btn_prev.style.visibility = "visible";
    }

    if (page == total_pages) {
        btn_next.style.visibility = "hidden";
    } 
    else {
        btn_next.style.visibility = "visible";
    }
}

function showMedia (phrase, pageNumber) {
    const myObject = {
        criteria: {
            search: {
                type: 'contains',
                value: phrase
            },
            type: 'image',
        },
        page: pageNumber,
        limit: limit,
    };
    const shallowEncoded = $.param( myObject );
    const shallowDecoded = decodeURIComponent( shallowEncoded );

    $.ajax({
        type: 'GET',
        url: route + '?' + shallowDecoded,
        dataType: 'JSON',
        success(data) {
        total_pages = numPages(data.total);
        changePage(current_page);
        const element = CKEDITOR.document.getById('grid');
        if (element) {
            element.setHtml(insertHtml(data._embedded.items));
        }
        },
        error(jqXHR, textStatus, errorThrown) {
        console.log(`ajax error ${textStatus} ${errorThrown}`);
        },
         });
}



CKEDITOR.dialog.add ('mediaDialog', editor => ({
    title: 'Insert products',
    minWidth: 200,
    minHeight: 200,
    resizable: CKEDITOR.DIALOG_RESIZE_NONE,
    onShow(api) {
        phrase = '';
        showMedia(phrase, current_page);
    },

    contents: [
        {
            id: "mediaContent",
                elements: [
                    {
                        type: 'text',
                        id: 'phrase',
                        label: 'Search by phrase',
                        inputStyle: 'text-align: left',
                        controlStyle: 'width: 100%',
                        onKeyUp: function() {
                                phrase = this.getValue();
                                if(oldValue === phrase){
                                    return;
                                }
                                    oldValue = this.getValue();
                                    changePage(current_page);
                                    showMedia(phrase, current_page);
                        }
                    },
                    {
                        type: 'hbox',
                        widths: [ '25%', '25%' ],
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
                                controlStyle: 'width: 4em'
                            },
                        ]
                    },
                    
                    {
                        type: 'html',
                        id: 'mediaGrid',
                        html: '<form class="mediaGrid" id="grid"></form>',
                    },
                    {
                        type: 'hbox',
                        widths: [ '25%', '25%', '25%' ],
                        style: 'width: 10em',
                        align: 'left',
                        children: [
                            {
                                type: 'html',
                                id: 'btn_prev',
                                html: '<button class="btn btn_prev" id="btn_prev" onclick="prevPage()">Previous</button>',
                            },
                            {
                                type: 'html',
                                id: 'pageNumber',
                                html: '<span class="pageNumber" id="pageNumber"></span>',
                            },
                            {
                                type: 'html',
                                id: 'btn_next',
                                html: '<button class="btn btn_next" id="btn_next" onclick="nextPage()">Next</button>',
                            },
                        ]
                    },
                   
                   
                ]
        },
    ],
    onOk() {
        const dialog = this;
        const document = CKEDITOR.document;
        const element = document.find( '.mediaInput:checked');
        const imagePath = element.getItem(0).getAttribute( 'image-path' );
        const imageWidth = dialog.getContentElement('mediaContent','imageWidth').getValue();
        const imageHeight = dialog.getContentElement('mediaContent','imageHeight').getValue();

        editor.insertHtml(`<img src="${imagePath}" alt="media-img" style="height:${imageWidth}px; width:${imageHeight}px"/>`);
    },
}));
