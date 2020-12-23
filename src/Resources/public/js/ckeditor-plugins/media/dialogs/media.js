CKEDITOR.dialog.add('mediaDialog', editor => ({
    title: 'Insert products',
    minWidth: 200,
    minHeight: 200,
    resizable: CKEDITOR.DIALOG_RESIZE_NONE,
    onLoad(api) {
        var output = [];
        var document = this.getElement().getDocument();
        var element = document.getById('grid');
        $.ajax({
            type: 'GET',
            url: route,
            data: jQuery.param({ page: 1, limit: 10 }),
            dataType: 'json',
            success(data) {
            output = data.map(media =>
                `<div class="media__item">
                  <label for="${media.code}">${media.name}</label>
                  <input image-path="${media.path}" class="mediaInput" type="radio" name="media" value="${media.code}">
                  <img class="media" src=" ${media.path} "/>
                </div>`
            ).join('');
            if (element) {
                element.setHtml(output);
            }
            },
            error(jqXHR, textStatus, errorThrown) {
            console.log(`ajax error ${textStatus} ${errorThrown}`);
            },
        });
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
                                $.ajax({
                                    type: 'GET',
                                    url: route,
                                    data: jQuery.param({ phrase: phrase, page: 1, limit: 10}),
                                    dataType: 'json',
                                    success(data) {
                                    var element = CKEDITOR.document.getById('grid');
                                    output = data.map(media =>
                                        `<div class="media__item">
                                          <label for="${media.code}">${media.name}</label>
                                          <input image-path="${media.path}" class="mediaInput" type="radio" name="media" value="${media.code}">
                                          <img class="media" src=" ${media.path} "/>
                                        </div>`
                                    ).join('');
                                    if (element) {
                                        element.setHtml(output);
                                    }
                                    },
                                    error(jqXHR, textStatus, errorThrown) {
                                    console.log(`ajax error ${textStatus} ${errorThrown}`);
                                    },
                                });
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
                        id: 'foo',
                        html: '<form class="mediaGrid" id="grid"></form>',
                    },

                ]
        },
    ],
    onOk() {
        const dialog = this;
        var document = CKEDITOR.document;

        var element = document.find( '.mediaInput:checked');
        var imgPath = element.getItem(0).getAttribute( 'image-path' );

        var imageWidth = dialog.getContentElement('mediaContent','imageWidth').getValue();
        var imageHeight = dialog.getContentElement('mediaContent','imageHeight').getValue();

        editor.insertHtml(`<img src="${imgPath}" alt="media-img" style="height:${imageWidth}px; width:${imageHeight}px"/>`);

    },
}));
