(function ( $ ) {
    'use strict';

    $.fn.extend({
        cmsResourcePreview: function(callback) {
            return this.each(function() {
                return $(this).on('click', function(event) {
                    event.preventDefault();

                    if (callback !== undefined) {
                        callback();
                    }
                    
                    var actionButton = $(this);
                    var form = actionButton.closest('form');
                    var url = actionButton.data('url');
                    var root = $('#bitbag-cms-resource-preview-modal');

                    $('#bitbag_sylius_cms_plugin_channel_switch, #bitbag_sylius_cms_plugin_locale_switch').on('change', function () {
                        // createPreview(form, url);
                    });

                    createPreview(form, url);

                    return root.modal('show');
                });
            });
        }
    });

    function createPreview(form, url) {
        $('#bitbag-cms-resource-preview-modal .ui.loadable').addClass('loading');

        var channelCode = $('#bitbag_sylius_cms_plugin_channel_switch').val();
        var localeCode = $('#bitbag_sylius_cms_plugin_locale_switch').val();

        $.ajax({
            url: url + '?' + '_channel_code=' + channelCode + '&' + '_locale=' + localeCode,
            type: 'POST',
            data: new FormData(form[0]),
            processData: false,
            contentType: false,
            cache: false,
        }).done(function(response) {
            console.log(response);
            var blob = new Blob([response], {type : 'text/html', charset: 'utf-8'});
            var blobUrl = window.URL.createObjectURL(blob);

            $('#bitbag-cms-resource-preview-modal iframe').attr('src', blobUrl);
            $('#bitbag-cms-resource-preview-modal .ui.loadable').removeClass('loading');
        });
    }
})( jQuery );

(function($) {
    $(document).ready(function () {
        $('.bitbag-cms-resource-preview').cmsResourcePreview(function () {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        })
    });
})(jQuery);
