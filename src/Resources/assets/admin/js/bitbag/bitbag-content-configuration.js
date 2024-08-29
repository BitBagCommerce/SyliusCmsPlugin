

$(document).ready(function() {
    $('.bitbag-media-autocomplete, .sylius-autocomplete').each((index, element) => {
        $(element).autoComplete();
    });

    let pageElements = '#sylius_cms_plugin_page_contentElements';
    let blockElements = '#sylius_cms_plugin_block_contentElements';

    let collectionHolder = $(pageElements).length ? pageElements : blockElements;

    if (!$(collectionHolder).length) {
        return;
    }

    $(document).on('collection-form-add', () => {
        $('.bitbag-media-autocomplete, .sylius-autocomplete').each((index, element) => {
            if ($._data($(element).get(0), 'events') === undefined) {
                $(element).autoComplete();
            }
        });

        $(`${collectionHolder} [data-form-collection="item"]`).each((index, element) => {
            $(document).loadContentConfiguration(element);
        });
    });

    $.fn.extend({
        loadContentConfiguration(target) {
            target.querySelector(`${collectionHolder} select[name*="type"]`).onchange = function () {
                const parent = this.parentElement;
                const newConfig = document.createElement('div');
                const selectedOption = this.selectedOptions[0];
                newConfig.innerHTML = selectedOption.getAttribute('data-configuration');

                const oldConfig = parent.nextElementSibling;

                parent.parentElement.replaceChild(newConfig, oldConfig);

                let oldConfigInput = oldConfig.querySelector('input');
                if (!oldConfigInput) {
                    oldConfigInput = oldConfig.querySelector('textarea');
                }

                const oldConfigInputName = oldConfigInput.getAttribute('name');

                let newConfigInputs = newConfig.querySelectorAll('input');
                if (!newConfigInputs.length) {
                    newConfigInputs = newConfig.querySelectorAll('textarea');
                }

                newConfigInputs.forEach(element => {
                    let newConfigInputName = element.getAttribute('name');
                    if (!newConfigInputName) {
                        return;
                    }

                    newConfigInputName = oldConfigInputName.replace(
                        oldConfigInputName.substring(oldConfigInputName.indexOf('[configuration]') + 15),
                        newConfigInputName.substring(newConfigInputName.indexOf('configuration') + 13),
                    );

                    $(element).attr('name', newConfigInputName);
                    $(newConfig).find('.bitbag-media-autocomplete').autoComplete();
                    $(newConfig).find('.sylius-autocomplete').autoComplete();
                });
            }
        }
    });

    $(`${collectionHolder} [data-form-collection="item"]`).each((index, element) => {
        $(document).loadContentConfiguration(element);
    });

    $(document).loadContentConfiguration(
        document.querySelector(`${collectionHolder} [data-form-collection="item"]`)
    );
});
