<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Block;

use DMore\ChromeDriver\ChromeDriver;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsErrorTrait;
use Tests\BitBag\SyliusCmsPlugin\Behat\Helpers\ContentElementHelper;
use Webmozart\Assert\Assert;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    public function fillCode(string $code): void
    {
        $this->getDocument()->fillField('Code', $code);
    }

    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);
    }

    public function fillNameIfItIsEmpty(string $name): void
    {
        if (empty($this->getDocument()->findField('Name')->getValue())) {
            $this->fillName($name);
        }
    }

    public function fillLink(string $link): void
    {
        $this->getDocument()->fillField('Link', $link);
    }

    public function fillContent(string $content): void
    {
        $this->getDocument()->fillField('Content', $content);
    }

    public function disable(): void
    {
        $this->getDocument()->uncheckField('Enabled');
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

        $textarea = $this->getElement('content_elements_textarea');
        $textarea->setValue($content);
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

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'association_dropdown_collection' => '.field > label:contains("Collections") ~ .sylius-autocomplete',
            'association_dropdown_collection_item' => '.field > label:contains("Collections") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
            'content_elements_add_button' => '#bitbag_sylius_cms_plugin_block_contentElements a[data-form-collection="add"]',
            'content_elements_select_type' => '.field > label:contains("Type") ~ select',
            'content_elements_textarea' => '.field > label:contains("Textarea") ~ textarea',
            'content_elements_single_media_dropdown' => '.field > label:contains("Single media") ~ .bitbag-media-autocomplete',
            'content_elements_single_media_dropdown_item' => '.field > label:contains("Single media") ~ .bitbag-media-autocomplete > div.menu > div.item:contains("%item%")',
            'content_elements_multiple_media_dropdown' => '.field > label:contains("Multiple media") ~ .bitbag-media-autocomplete',
            'content_elements_multiple_media_dropdown_item' => '.field > label:contains("Multiple media") ~ .bitbag-media-autocomplete > div.menu > div.item:contains("%item%")',
            'content_elements_heading' => '.field > label:contains("Heading type") ~ select',
            'content_elements_heading_content' => '.field > label:contains("Heading") ~ input[type="text"]',
            'content_elements_products_carousel' => '.field > label:contains("Products") ~ .sylius-autocomplete',
            'content_elements_products_carousel_item' => '.field > label:contains("Products") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
            'content_elements_products_carousel_by_taxon' => '.field > label:contains("Taxon") ~ .sylius-autocomplete',
            'content_elements_products_carousel_by_taxon_item' => '.field > label:contains("Taxon") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
            'content_elements_products_grid' => '.field > label:contains("Products") ~ .sylius-autocomplete',
            'content_elements_products_grid_item' => '.field > label:contains("Products") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
            'content_elements_products_grid_by_taxon' => '.field > label:contains("Taxon") ~ .sylius-autocomplete',
            'content_elements_products_grid_by_taxon_item' => '.field > label:contains("Taxon") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
            'content_elements_taxons_list' => '.field > label:contains("Taxons") ~ .sylius-autocomplete',
            'content_elements_taxons_list_item' => '.field > label:contains("Taxons") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
        ]);
    }
}
