<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Page;

use DMore\ChromeDriver\ChromeDriver;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Sylius\Behat\Service\SlugGenerationHelper;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsErrorTrait;
use Tests\Sylius\CmsPlugin\Behat\Helpers\ContentElementHelper;
use Tests\Sylius\CmsPlugin\Behat\Service\FormHelper;
use Webmozart\Assert\Assert;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    public function chooseImage(string $code): void
    {
        FormHelper::fillHiddenInput($this->getSession(), self::IMAGE_FORM_ID, $code);
    }

    public function fillCode(string $code): void
    {
        $this->getDocument()->fillField('Code', $code);
    }

    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);

        if ($this->getDriver() instanceof ChromeDriver) {
            SlugGenerationHelper::waitForSlugGeneration($this->getSession(), $this->getElement('slug'));
        }
    }

    public function fillSlug(string $slug): void
    {
        $this->getDocument()->fillField('Slug', $slug);
    }

    public function fillMetaKeywords(string $metaKeywords): void
    {
        $this->getDocument()->fillField('Meta keywords', $metaKeywords);
    }

    public function fillMetaDescription(string $metaDescription): void
    {
        $this->getDocument()->fillField('Meta description', $metaDescription);
    }

    public function fillContent(string $content): void
    {
        $this->getDocument()->fillField('Content', $content);
    }

    public function associateCollections(array $collectionsNames): void
    {
        Assert::isInstanceOf($this->getDriver(), ChromeDriver::class);

        $dropdown = $this->getElement('association_dropdown_collection');
        $dropdown->click();

        foreach ($collectionsNames as $collectionName) {
            $dropdown->waitFor(5, function () use ($collectionName): bool {
                return $this->hasElement('association_dropdown_collection_item', [
                    '%item%' => $collectionName,
                ]);
            });

            $item = $this->getElement('association_dropdown_collection_item', [
                '%item%' => $collectionName,
            ]);

            $item->click();
        }
    }

    public function clickOnAddContentElementButton(): void
    {
        Assert::isInstanceOf($this->getDriver(), ChromeDriver::class);

        $addButton = $this->getElement('content_elements_add_button');
        $addButton->click();

        $addButton->waitFor(1, function (): bool {
            return $this->hasElement('content_elements_select_type');
        });
    }

    public function selectContentElement(string $contentElement): void
    {
        Assert::isInstanceOf($this->getDriver(), ChromeDriver::class);

        $select = $this->getElement('content_elements_select_type');
        $select->selectOption($contentElement);
        $select->waitFor(1, function () use ($contentElement): bool {
            return $this->hasElement(
                ContentElementHelper::getDefinedElementThatShouldAppearAfterSelectContentElement($contentElement),
            );
        });
    }

    public function addTextareaContentElementWithContent(string $content): void
    {
        Assert::isInstanceOf($this->getDriver(), ChromeDriver::class);

        $iframe = $this->getDocument()->find('css', '.cke_wysiwyg_frame');
        if (null === $iframe) {
            $textarea = $this->getElement('content_elements_textarea');
            $textarea->setValue($content);

            return;
        }

        $this->getDriver()->switchToIFrame($iframe->getAttribute('name'));

        $body = $this->getDocument()->find('css', 'body');
        if (null === $body) {
            throw new \Exception('CKEditor body not found');
        }

        $body->setValue($content);

        $this->getDriver()->switchToIFrame();
    }

    public function addSingleMediaContentElementWithName(string $name): void
    {
        $dropdown = $this->getElement('content_elements_single_media_dropdown');
        $dropdown->click();

        $dropdown->waitFor(5, function () use ($name): bool {
            return $this->hasElement('content_elements_single_media_dropdown_item', [
                '%item%' => $name,
            ]);
        });

        $item = $this->getElement('content_elements_single_media_dropdown_item', [
            '%item%' => $name,
        ]);

        $item->click();
    }

    public function addMultipleMediaContentElementWithNames(array $mediaNames): void
    {
        $dropdown = $this->getElement('content_elements_multiple_media_dropdown');
        $dropdown->click();

        foreach ($mediaNames as $mediaName) {
            $dropdown->waitFor(5, function () use ($mediaName): bool {
                return $this->hasElement('content_elements_multiple_media_dropdown_item', [
                    '%item%' => $mediaName,
                ]);
            });

            $item = $this->getElement('content_elements_multiple_media_dropdown_item', [
                '%item%' => $mediaName,
            ]);

            $item->click();
        }
    }

    public function addHeadingContentElementWithTypeAndContent(string $type, string $content): void
    {
        $heading = $this->getElement('content_elements_heading');
        $heading->selectOption($type);

        $headingContent = $this->getElement('content_elements_heading_content');
        $headingContent->setValue($content);
    }

    public function addProductsCarouselContentElementWithProducts(array $productsNames): void
    {
        $dropdown = $this->getElement('content_elements_products_carousel');
        $dropdown->click();

        foreach ($productsNames as $productName) {
            $dropdown->waitFor(5, function () use ($productName): bool {
                return $this->hasElement('content_elements_products_carousel_item', [
                    '%item%' => $productName,
                ]);
            });

            $item = $this->getElement('content_elements_products_carousel_item', [
                '%item%' => $productName,
            ]);

            $item->click();
        }
    }

    public function addProductsCarouselByTaxonContentElementWithTaxon(string $taxon): void
    {
        $dropdown = $this->getElement('content_elements_products_carousel_by_taxon');
        $dropdown->click();

        $dropdown->waitFor(5, function () use ($taxon): bool {
            return $this->hasElement('content_elements_products_carousel_by_taxon_item', [
                '%item%' => $taxon,
            ]);
        });

        $item = $this->getElement('content_elements_products_carousel_by_taxon_item', [
            '%item%' => $taxon,
        ]);

        $item->click();
    }

    public function addProductsGridContentElementWithProducts(array $productsNames): void
    {
        $dropdown = $this->getElement('content_elements_products_grid');
        $dropdown->click();

        foreach ($productsNames as $productName) {
            $dropdown->waitFor(5, function () use ($productName): bool {
                return $this->hasElement('content_elements_products_grid_item', [
                    '%item%' => $productName,
                ]);
            });

            $item = $this->getElement('content_elements_products_grid_item', [
                '%item%' => $productName,
            ]);

            $item->click();
        }
    }

    public function addProductsGridByTaxonContentElementWithTaxon(string $taxon): void
    {
        $dropdown = $this->getElement('content_elements_products_grid_by_taxon');
        $dropdown->click();

        $dropdown->waitFor(5, function () use ($taxon): bool {
            return $this->hasElement('content_elements_products_grid_by_taxon_item', [
                '%item%' => $taxon,
            ]);
        });

        $item = $this->getElement('content_elements_products_grid_by_taxon_item', [
            '%item%' => $taxon,
        ]);

        $item->click();
    }

    public function addTaxonsListContentElementWithTaxons(array $taxons): void
    {
        $dropdown = $this->getElement('content_elements_taxons_list');
        $dropdown->click();

        foreach ($taxons as $taxon) {
            $dropdown->waitFor(5, function () use ($taxon): bool {
                return $this->hasElement('content_elements_taxons_list_item', [
                    '%item%' => $taxon,
                ]);
            });

            $item = $this->getElement('content_elements_taxons_list_item', [
                '%item%' => $taxon,
            ]);

            $item->click();
        }
    }

    public function selectContentTemplate(string $templateName): void
    {
        $dropdown = $this->getElement('content_template_select_dropdown');
        $dropdown->click();

        $dropdown->waitFor(5, function () use ($templateName): bool {
            return $this->hasElement('content_template_select_dropdown_item', [
                '%item%' => $templateName,
            ]);
        });

        $item = $this->getElement('content_template_select_dropdown_item', [
            '%item%' => $templateName,
        ]);

        $item->click();
    }

    public function confirmUseTemplate(): void
    {
        $this->getDocument()->findById('load-template-confirmation-button')->click();
        $this->getDocument()->waitFor(1, function () {
            return false;
        });
    }

    public function selectTemplate(string $templateName): void
    {
        $this->getDocument()->selectFieldOption('Template', $templateName);
    }

    public function selectChannel(string $code): void
    {
        $this->getDocument()->checkField($code);
    }

    protected function getDefinedElements(): array
    {
        return array_merge(
            parent::getDefinedElements(),
            ContentElementHelper::getDefinedContentElements(),
            [
                'slug' => '#sylius_cms_page_translations_en_US_slug',
                'association_dropdown_collection' => '.field > label:contains("Collections") ~ .sylius-autocomplete',
                'association_dropdown_collection_item' => '.field > label:contains("Collections") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
                'content_elements_add_button' => '#sylius_cms_page_contentElements a[data-form-collection="add"]',
                'content_template_select_dropdown' => 'h5:contains("Content elements template") ~ .column .field > .sylius-autocomplete',
                'content_template_select_dropdown_item' => 'h5:contains("Content elements template") ~ .column .field > .sylius-autocomplete > div.menu > div.item:contains("%item%")',
            ],
        );
    }
}
