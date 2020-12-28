let oldValue = null;
let currentPage = 1;

function insertHtml(data) {
    var output = data.map(media =>
        `<div class="media__item">
          <label for="${media.code}">${media.name}</label>
          <input image-path="${media.path}" class="mediaInput" type="radio" name="media" value="${media.code}">
          <img class="media" src=" ${media.path} "/>
        </div>`
    ).join('');
    return output;
}

function ajaxCall(phrase) {
    console.log("ajax call");

    var myObject = {
        criteria: {
            search: {
                type: 'contains',
                value: phrase
            },
            type: 'image',
        },
        page: currentPage,
        limit: 20,
    };
      var shallowEncoded = $.param( myObject );
      var shallowDecoded = decodeURIComponent( shallowEncoded );

    $.ajax({
        type: 'GET',
        url: route + '?' + shallowDecoded,
        dataType: 'JSON',
        success(data) {
        var element = CKEDITOR.document.getById('grid');
        if(data.length == 10){
            var paginationContainer = CKEDITOR.document.getById('pagination');
            if (paginationContainer) {
                paginationContainer.setHtml(
                    `<button class="media__button">Next page..</button>`
                );
            }
        }
        else {
            var paginationContainer = CKEDITOR.document.getById('pagination');
            var pageNum = 1;
            if (paginationContainer) {
                paginationContainer.setHtml(
                    ``
                );

            }
        }
        $('button').on('click', function () {
            console.log("page has been changed");
            currentPage++;
        });

        if (element) {
            element.setHtml(insertHtml(data._embedded.items));
        }
        },
        error(jqXHR, textStatus, errorThrown) {
        console.log(`ajax error ${textStatus} ${errorThrown}`);
        },
         });
}



CKEDITOR.dialog.add('mediaDialog', editor => ({
    title: 'Insert products',
    minWidth: 200,
    minHeight: 200,
    resizable: CKEDITOR.DIALOG_RESIZE_NONE,
    onShow(api) {
        let phrase = '';
        ajaxCall(phrase);
    },

    contents: [
        {
            id: "mediaContent",
                elements: [
                    {
                        type: 'text',
                        id: 'phrase',
                        label: 'Search by phrase',
                        inputStyle: 'text-align: center',
                        controlStyle: 'width: 3em',
                        onKeyUp: function() {
                                var phrase = this.getValue();
                                if(oldValue === phrase){
                                    return;
                                }
                                    oldValue = this.getValue();
                                    ajaxCall(phrase);
                        }
                    },
                    {
                        type: 'text',
                        id: 'imageWidth',
                        label: 'ImageWidth',
                        inputStyle: 'text-align: center',
                        controlStyle: 'width: 3em'
                    },
                    {
                        type: 'text',
                        id: 'imageHeight',
                        default: '200',
                        label: 'ImageHeight',
                        inputStyle: 'text-align: center',
                        controlStyle: 'width: 3em'
                    },
                    {
                        type: 'html',
                        id: 'mediaGrid',
                        html: '<form class="mediaGrid" id="grid"></form>',
                    },
                    {
                        type: 'html',
                        id: 'pagination',
                        html: '<div class="pagination" id="pagination"></div>',
                    },

                ]
        },
    ],
    onOk() {
        const dialog = this;
        const document = CKEDITOR.document;
        const element = document.find( '.mediaInput:checked');
        const imgPath = element.getItem(0).getAttribute( 'image-path' );
        const imageWidth = dialog.getContentElement('mediaContent','imageWidth').getValue();
        const imageHeight = dialog.getContentElement('mediaContent','imageHeight').getValue();

        editor.insertHtml(`<img src="${imgPath}" alt="media-img" style="height:${imageWidth}px; width:${imageHeight}px"/>`);

    },
}));
