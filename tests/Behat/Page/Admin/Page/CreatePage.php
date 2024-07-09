<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Page;

use Behat\Mink\Exception\ElementNotFoundException;
use DMore\ChromeDriver\ChromeDriver;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Sylius\Behat\Service\SlugGenerationHelper;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsErrorTrait;
use Tests\BitBag\SyliusCmsPlugin\Behat\Helpers\ContentElementHelper;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\FormHelper;
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
            $dropdown->waitFor(10, function () use ($collectionName): bool {
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

    /**
     * @throws ElementNotFoundException
     */
    public function clickOnAddContentElementButton(): void
    {
        Assert::isInstanceOf($this->getDriver(), ChromeDriver::class);

        $addButton = $this->getElement('content_elements_add_button');
        $addButton->click();

        $addButton->waitFor(2, function (): bool {
            return $this->hasElement('content_elements_select_type');
        });
    }

    /**
     * @throws ElementNotFoundException
     */
    public function selectContentElement(string $contentElement): void
    {
        Assert::isInstanceOf($this->getDriver(), ChromeDriver::class);

        $select = $this->getElement('content_elements_select_type');
        $select->selectOption($contentElement);
        $select->waitFor(3, function () use ($contentElement): bool {
            return $this->hasElement(
                ContentElementHelper::getDefinedElementThatShouldAppearAfterSelectContentElement($contentElement),
            );
        });
    }

    /**
     * @throws ElementNotFoundException
     */
    public function addTextareaContentElementWithContent(string $content): void
    {
        Assert::isInstanceOf($this->getDriver(), ChromeDriver::class);

        $textarea = $this->getElement('content_elements_textarea');
        $textarea->setValue($content);
    }

    /**
     * @throws ElementNotFoundException
     */
    public function addSingleMediaContentElementWithName(string $name): void
    {
        $dropdown = $this->getElement('content_elements_single_media_dropdown');
        $dropdown->click();

        $dropdown->waitFor(10, function () use ($name): bool {
            return $this->hasElement('content_elements_single_media_dropdown_item', [
                '%item%' => $name,
            ]);
        });

        $item = $this->getElement('content_elements_single_media_dropdown_item', [
            '%item%' => $name,
        ]);

        $item->click();
    }

    /**
     * @throws ElementNotFoundException
     */
    public function addMultipleMediaContentElementWithNames(array $mediaNames): void
    {
        $dropdown = $this->getElement('content_elements_multiple_media_dropdown');
        $dropdown->click();

        foreach ($mediaNames as $mediaName) {
            $dropdown->waitFor(10, function () use ($mediaName): bool {
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

    /**
     * @throws ElementNotFoundException
     */
    public function addHeadingContentElementWithTypeAndContent(string $type, string $content): void
    {
        $heading = $this->getElement('content_elements_heading');
        $heading->selectOption($type);

        $headingContent = $this->getElement('content_elements_heading_content');
        $headingContent->setValue($content);
    }

    /**
     * @throws ElementNotFoundException
     */
    public function addProductsCarouselContentElementWithProducts(array $productsNames): void
    {
        $dropdown = $this->getElement('content_elements_products_carousel');
        $dropdown->click();

        foreach ($productsNames as $productName) {
            $dropdown->waitFor(10, function () use ($productName): bool {
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

    /**
     * @throws ElementNotFoundException
     */
    public function addProductsCarouselByTaxonContentElementWithTaxon(string $taxon): void
    {
        $dropdown = $this->getElement('content_elements_products_carousel_by_taxon');
        $dropdown->click();

        $dropdown->waitFor(10, function () use ($taxon): bool {
            return $this->hasElement('content_elements_products_carousel_by_taxon_item', [
                '%item%' => $taxon,
            ]);
        });

        $item = $this->getElement('content_elements_products_carousel_by_taxon_item', [
            '%item%' => $taxon,
        ]);

        $item->click();
    }

    public function addTaxonsListContentElementWithTaxons(array $taxons): void
    {
        $dropdown = $this->getElement('content_elements_taxons_list');
        $dropdown->click();

        foreach ($taxons as $taxon) {
            $dropdown->waitFor(10, function () use ($taxon): bool {
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
            'slug' => '#bitbag_sylius_cms_plugin_page_translations_en_US_slug',
            'association_dropdown_collection' => '.field > label:contains("Collections") ~ .sylius-autocomplete',
            'association_dropdown_collection_item' => '.field > label:contains("Collections") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
            'content_elements_add_button' => '#bitbag_sylius_cms_plugin_page_contentElements a[data-form-collection="add"]',
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
            'content_elements_taxons_list' => '.field > label:contains("Taxons") ~ .sylius-autocomplete',
            'content_elements_taxons_list_item' => '.field > label:contains("Taxons") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
        ]);
    }
}
