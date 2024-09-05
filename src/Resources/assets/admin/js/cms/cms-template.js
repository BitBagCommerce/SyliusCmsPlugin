export class HandleTemplate {
    init() {
        $(document).ready(() => {
            const cmsLoadTemplate = $('[data-bb-cms-load-template]');
            const cmsPageTemplate = $('#sylius_cms_page_template');
            const cmsBlockTemplate = $('#sylius_cms_block_template');

            cmsLoadTemplate.on('click', function (e) {
                e.preventDefault();

                if (!cmsPageTemplate.val() && !cmsBlockTemplate.val()) {
                    return;
                }

                $('#load-template-confirmation-modal').modal('show');
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
                                $('[data-form-collection="add"]').trigger('click');
                            });

                            const elements = $('[id^="sylius_cms_"][id*="_contentElements_"][id$="_type"]').filter(function() {
                                return /_page_|_block_/.test(this.id);
                            });

                            $.each(data.content, function (index, element) {
                                if (element.type.toString() === "textarea") {
                                    elements.eq(index).val("textarea");
                                    elements.eq(index).change();
                                } else if (element.type.toString() === "single_media") {
                                    elements.eq(index).val("single_media");
                                    elements.eq(index).change();
                                } else {
                                    elements.eq(index).val("multiple_media");
                                    elements.eq(index).change();
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
        });
    }
}

export default HandleTemplate;