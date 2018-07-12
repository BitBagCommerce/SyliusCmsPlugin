(function ( $ ) {
    'use strict';

    $.fn.extend({
        cmsResourcePreview: function(callback) {
            return this.each(function() {
                return $(this).on('click', function(event) {
                    event.preventDefault();

                    $('#bitbag-cms-resource-preview-modal iframe').on( 'load', function() {
                        $('#bitbag-cms-resource-preview-modal .ui.loadable').removeClass('loading');
                    });

                    if (callback !== undefined) {
                        callback();
                    }
                    
                    var actionButton = $(this);
                    
                    var form = actionButton.closest('form');
                    var url = actionButton.data('url');
                    var root = $('#bitbag-cms-resource-preview-modal');

                    $('#bitbag_sylius_cms_plugin_channel_switch, #bitbag_sylius_cms_plugin_locale_switch').on('change', function () {
                        createPreview(root, form, url);
                    });

                    createPreview(root, form, url);

                    return root.modal('show');
                });
            });
        }
    });

    function createPreview(root, form, url) {
        $('#bitbag-cms-resource-preview-modal .ui.loadable').addClass('loading');

        var channelCode = $('#bitbag_sylius_cms_plugin_channel_switch').val();
        var localeCode = $('#bitbag_sylius_cms_plugin_locale_switch').val();

        var query = form.serialize();

        $('#bitbag-cms-resource-preview-modal iframe').attr('src', url + '?' + query + '&' + '_channel_code=' + channelCode + '&' + '_locale=' + localeCode);
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
