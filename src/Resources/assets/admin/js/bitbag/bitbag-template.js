/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

export class HandleTemplate {
    init() {
        $(document).ready(() => {
            const cmsLoadTemplate = $('[data-bb-cms-load-template]');
            const cmsPageTemplate = $('#bitbag_sylius_cms_plugin_page_template');

            cmsLoadTemplate.on('click', function (e) {
                e.preventDefault();

                if (!cmsPageTemplate.val()) {
                    return;
                }

                $('#load-template-confirmation-modal').modal('show');
            });

            $('#load-template-confirmation-button').on('click', function (e) {
                const templateId = cmsPageTemplate.val();
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
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            $('[id^="bitbag_sylius_cms_plugin_"][id$="contentElements"]')
                                .children('[data-form-collection="list"]')
                                .html('');

                            $.each(data.content, function () {
                                $('[data-form-collection="add"]').trigger('click');
                            });

                            const elements = $('[id^="bitbag_sylius_cms_plugin_page_contentElements_"][id$="_type"]');

                            $.each(data.content, function (index, element) {
                                elements.eq(index).val(element.type);
                                elements.eq(index).change();
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
        });
    }
}

export default HandleTemplate;
