export class HandleTemplate {
    init() {
        $(document).ready(() => {
            const cmsLoadTemplate = $('[data-bb-cms-load-template]');
            const cmsPageTemplate = $('#sylius_cms_page_template');
            const cmsBlockTemplate = $('#sylius_cms_block_template');

            let locales = [];
            $('.locale-selector option').each(function() {
                locales.push($(this).val());
            });

            cmsPageTemplate.on('change', function() {
                if ($(this).val()) {
                    $('#load-template-confirmation-modal').modal('show');
                }
            });

            cmsBlockTemplate.on('change', function() {
                if ($(this).val()) {
                    $('#load-template-confirmation-modal').modal('show');
                }
            });

            $('#load-template-confirmation-button').on('click', function () {
                const templateId = cmsPageTemplate.val() ?? cmsBlockTemplate.val();
                if (!templateId) {
                    return;
                }

                const endpointUrl = cmsLoadTemplate.data('bb-cms-load-template').replace('REPLACE_ID', templateId);
                if (!endpointUrl) {
                    return;
                }

                $.ajax({
                    url: endpointUrl,
                    type: 'GET',
                    success: function(data) {
                        if (data.status === 'success') {
                            $('[id^="sylius_cms_"][id$="contentElements"]')
                                .children('[data-form-collection="list"]')
                                .html('');

                            $.each(data.content, function () {
                                locales.forEach(function (locale) {
                                    $('[data-form-collection="add"]').trigger('click');
                                });
                            });

                            const elements = $('.bb-collection-item');
                            let idx = 0;
                            $.each(data.content, function (index, element) {
                                locales.forEach(function (locale) {
                                    elements.eq(idx).find('select:first').val(element.type);
                                    elements.eq(idx).find('select:first').change();
                                    elements.eq(idx).find('input[name$="[locale]"]').val(locale);
                                    idx++;
                                });
                            });

                            $('.content-elements-container').find('.bb-collection-item').each(function() {
                                const $element = $(this);
                                const elementLocale = $element.find('input[name$="[locale]"]').val();

                                if (elementLocale === $('.locale-selector').val()) {
                                    $element.show();
                                } else {
                                    $element.hide();
                                }
                            });
                        } else {
                            console.error(data.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error:', textStatus, errorThrown);
                    }
                });
            });

            $('#load-template-cancel-button').on('click', function () {
                cmsPageTemplate.val('');
                cmsBlockTemplate.val('');
            });
        });
    }
}

export default HandleTemplate;
