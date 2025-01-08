export class HandleTemplate {
    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.setup();
        });
    }

    setup() {
        const cmsLoadTemplate = document.querySelector('[data-bb-cms-load-content-template]');
        const cmsPageTemplate = document.getElementById('sylius_cms_page_contentTemplate');
        const cmsBlockTemplate = document.getElementById('sylius_cms_block_contentTemplate');
        const contentElementsContainer = document.querySelector('.content-elements-container');

        if (!cmsLoadTemplate || (!cmsPageTemplate && !cmsBlockTemplate)) {
            console.warn('Required elements not found.');
            return;
        }

        this.locales = this.getLocales();
        this.attachTemplateChangeListeners(cmsPageTemplate, cmsBlockTemplate);
        this.attachConfirmationButtonListener(cmsLoadTemplate, contentElementsContainer);
        this.attachCancelButtonListener(cmsPageTemplate, cmsBlockTemplate);
    }

    getLocales() {
        return Array.from(document.querySelectorAll('.locale-selector option')).map(option => option.value);
    }

    attachTemplateChangeListeners(cmsPageTemplate, cmsBlockTemplate) {
        const showModalIfValue = (element) => {
            if (element?.value) {
                const modal = document.getElementById('load-template-confirmation-modal');
                modal.style.display = 'block';
                modal.classList.add('show');
            }
        };

        cmsPageTemplate?.addEventListener('change', () => showModalIfValue(cmsPageTemplate));
        cmsBlockTemplate?.addEventListener('change', () => showModalIfValue(cmsBlockTemplate));
    }

    attachConfirmationButtonListener(cmsLoadTemplate, contentElementsContainer) {
        document.getElementById('load-template-confirmation-button').addEventListener('click', () => {
            const templateId = this.getSelectedTemplateId();
            if (!templateId) return;

            const endpointUrl = cmsLoadTemplate.dataset.bbCmsLoadContentTemplate.replace('REPLACE_ID', templateId);
            if (!endpointUrl) return;

            this.loadTemplate(endpointUrl, contentElementsContainer);
        });
    }

    getSelectedTemplateId() {
        const cmsPageTemplate = document.getElementById('sylius_cms_page_contentTemplate');
        const cmsBlockTemplate = document.getElementById('sylius_cms_block_contentTemplate');
        return cmsPageTemplate?.value || cmsBlockTemplate?.value || null;
    }

    loadTemplate(url, contentElementsContainer) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    this.clearExistingContentElements();
                    this.addContentElements(data.content, contentElementsContainer);
                    this.hideModal();
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    clearExistingContentElements() {
        document.querySelectorAll('[id^="sylius_cms_"][id$="contentElements"]').forEach(element => {
            element.querySelectorAll('.collection-item').forEach(item => {
                item.querySelector('[data-live-action-param="removeCollectionItem"]')?.click();
            });
        });
    }

    addContentElements(content, contentElementsContainer) {
        const totalContentElements = content.length * this.locales.length;
        content.forEach(element => {
            this.locales.forEach(locale => {
                setTimeout(() => {
                    document.querySelector(`[data-live-type-param="${element.type}"]`)?.click();
                }, 100);
            });
        });

        this.observeContentElementAddition(totalContentElements, content, contentElementsContainer);
    }

    observeContentElementAddition(totalContentElements, content, container) {
        const observer = new MutationObserver(() => {
            const currentElementCount = container.querySelectorAll('.collection-item').length;
            if (currentElementCount === totalContentElements) {
                this.populateContentElements(content);
                this.filterContentElementsByLocale();
                observer.disconnect();
            }
        });

        observer.observe(container, { childList: true, subtree: true });
    }

    populateContentElements(content) {
        const elements = document.querySelectorAll('.collection-item');
        let index = 0;

        content.forEach(() => {
            this.locales.forEach(locale => {
                const item = elements[index];
                item.querySelector('input[name$="[locale]"]').value = locale;
                index++;
            });
        });
    }

    filterContentElementsByLocale() {
        const currentLocale = document.querySelector('.locale-selector').value;

        document.querySelectorAll('.content-elements-container .collection-item').forEach(element => {
            const elementLocale = element.querySelector('input[name$="[locale]"]').value;
            element.style.display = (elementLocale === currentLocale) ? 'block' : 'none';
        });
    }

    attachCancelButtonListener(cmsPageTemplate, cmsBlockTemplate) {
        document.getElementById('load-template-cancel-button').addEventListener('click', () => {
            this.hideModal();
            this.clearTemplateSelection(cmsPageTemplate);
            this.clearTemplateSelection(cmsBlockTemplate);
        });
    }

    hideModal() {
        const modal = document.getElementById('load-template-confirmation-modal');
        modal.classList.remove('show');
        modal.style.display = 'none';
    }

    clearTemplateSelection(template) {
        if (template) {
            template.value = '';
            template.nextElementSibling?.querySelector('.clear-button')?.click();
        }
    }
}

export default HandleTemplate;
