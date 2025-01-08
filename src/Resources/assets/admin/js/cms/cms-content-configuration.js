document.addEventListener('DOMContentLoaded', function() {
    const localeSelector = document.querySelector('.locale-selector');
    const contentElementsContainer = document.querySelector('.content-elements-container');

    function updateContentElementsVisibility() {
        const selectedLocale = localeSelector.value;

        contentElementsContainer.querySelectorAll('.collection-item').forEach(function(element) {
            const elementLocale = element.querySelector('input[name$="[locale]"]').value;
            console.log(elementLocale);
            if (elementLocale === selectedLocale) {
                element.style.display = 'block';
            } else {
                element.style.display = 'none';
            }
        });
    }

    localeSelector.addEventListener('change', updateContentElementsVisibility);

    updateContentElementsVisibility();

    const ckeditorConfig = {
        toolbar: [
            ["Cut", "Copy", "Paste", "PasteText", "PasteFromWord", "-", "Undo", "Redo"],
            ["Scayt"], ["Link", "Unlink", "Anchor"],
            ["Image", "MediaVideo", "MediaImage", "Table", "HorizontalRule", "SpecialChar"],
            ["Maximize"], ["Source"], "/",
            ["Bold", "Italic", "Strike", "-", "RemoveFormat"],
            ["NumberedList", "BulletedList", "-", "Outdent", "Indent", "-", "Blockquote"],
            ["Styles", "Format", "About"]
        ],
        enterMode: 3,
        forcePasteAsPlainText: "allow-word",
        allowedContent: true,
        extraPlugins: ["mediaVideo", "mediaImage"],
        removePlugins: ["exportpdf"],
        filebrowserUploadUrl: "/admin/editor/upload-image",
        bodyId: "cms-ckeditor",
        language: "en-us"
    };

    const addButton = document.querySelectorAll('[data-live-action-param="addCollectionItem"]');
    addButton.forEach(function(element) {
        element.addEventListener('click', function() {
            setTimeout(function() {
                const addedContentElement = contentElementsContainer.querySelector('.collection-item:last-child');
                const textarea = addedContentElement.querySelector('textarea');
                if (textarea) {
                    console.log('CKEDITOR');
                    if (typeof CKEDITOR !== 'undefined') {
                        CKEDITOR.replace(textarea, ckeditorConfig);
                    }
                }
            }, 500);
        });
    });
});


//
// $(document).ready(function() {
//     const localeSelector = $('.locale-selector');
//     const ckeditorConfig = {
//         toolbar: [
//             ["Cut", "Copy", "Paste", "PasteText", "PasteFromWord", "-", "Undo", "Redo"],
//             ["Scayt"], ["Link", "Unlink", "Anchor"],
//             ["Image", "MediaVideo", "MediaImage", "Table", "HorizontalRule", "SpecialChar"],
//             ["Maximize"], ["Source"], "/",
//             ["Bold", "Italic", "Strike", "-", "RemoveFormat"],
//             ["NumberedList", "BulletedList", "-", "Outdent", "Indent", "-", "Blockquote"],
//             ["Styles", "Format", "About"]
//         ],
//         enterMode: 3,
//         forcePasteAsPlainText: "allow-word",
//         allowedContent: true,
//         extraPlugins: ["mediaVideo", "mediaImage"],
//         removePlugins: ["exportpdf"],
//         filebrowserUploadUrl: "/admin/editor/upload-image",
//         bodyId: "cms-ckeditor",
//         language: "en-us"
//     };
//
//     let pageElements = '#sylius_cms_page_contentElements';
//     let blockElements = '#sylius_cms_block_contentElements';
//     let collectionHolder = $(pageElements).length ? pageElements : blockElements;
//
//     let itemElement = document.querySelector(`${collectionHolder} [data-form-collection="item"]`);
//
//     if (!$(collectionHolder).length) {
//         return;
//     }
//
//     $(document).on('collection-form-add', () => {
//         $('.cms-media-autocomplete, .sylius-autocomplete').each((index, element) => {
//             if ($._data($(element).get(0), 'events') === undefined) {
//                 $(element).autoComplete();
//             }
//         });
//
//         $(`${collectionHolder} [data-form-collection="item"]`).each((index, element) => {
//             $(document).loadContentConfiguration(element);
//         });
//
//         $('.bb-collection-item:last-child').find('input[name$="[locale]"]').val(localeSelector.val());
//     });
//     $.fn.extend({
//         loadContentConfiguration(target) {
//             target.querySelector(`${collectionHolder} select[name*="type"]`).onchange = function () {
//                 const parent = this.parentElement;
//                 const newConfig = document.createElement('div');
//                 const selectedOption = this.selectedOptions[0];
//                 newConfig.innerHTML = selectedOption.getAttribute('data-configuration');
//                 const oldConfig = parent.nextElementSibling;
//                 parent.parentElement.replaceChild(newConfig, oldConfig);
//                 let oldConfigInput = oldConfig.querySelector('input');
//                 if (!oldConfigInput) {
//                     oldConfigInput = oldConfig.querySelector('textarea');
//                 }
//                 const oldConfigInputName = oldConfigInput.getAttribute('name');
//                 let newConfigInputs = newConfig.querySelectorAll('input');
//                 if (!newConfigInputs.length) {
//                     newConfigInputs = newConfig.querySelectorAll('textarea');
//                 }
//                 newConfigInputs.forEach(element => {
//                     let newConfigInputName = element.getAttribute('name');
//                     if (!newConfigInputName) {
//                         return;
//                     }
//                     newConfigInputName = oldConfigInputName.replace(
//                         oldConfigInputName.substring(oldConfigInputName.indexOf('[configuration]') + 15),
//                         newConfigInputName.substring(newConfigInputName.indexOf('configuration') + 13),
//                     );
//                     $(element).attr('name', newConfigInputName);
//                     $(newConfig).find('.cms-media-autocomplete').autoComplete();
//                     $(newConfig).find('.sylius-autocomplete').autoComplete();
//
//                     if (this.value === 'textarea') {
//                         const index = target.getAttribute('data-form-collection-index');
//                         const textareaId = `${collectionHolder}_${index}_configuration_textarea`;
//
//                         element.id = textareaId;
//
//                         if (typeof CKEDITOR !== 'undefined') {
//                             CKEDITOR.replace(textareaId, ckeditorConfig);
//                         }
//                     }
//                 });
//             }
//         }
//     });
//     $(`${collectionHolder} [data-form-collection="item"]`).each((index, element) => {
//         $(document).loadContentConfiguration(element);
//     });
//
//     if (itemElement) {
//         $(document).loadContentConfiguration(itemElement);
//     }
// });
