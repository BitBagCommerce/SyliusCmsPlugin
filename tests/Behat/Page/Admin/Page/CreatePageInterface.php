<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Page;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    public const IMAGE_FORM_ID = 'sylius_cms_plugin_page_translations_en_US_image';

    public function fillField(string $field, string $value): void;

    public function chooseImage(string $code): void;

    public function fillCode(string $code): void;

    public function fillName(string $name): void;

    public function fillSlug(string $slug): void;

    public function fillMetaKeywords(string $metaKeywords): void;

    public function fillMetaDescription(string $metaDescription): void;

    public function fillContent(string $content): void;

    public function associateCollections(array $collectionsNames): void;

    public function clickOnAddContentElementButton(): void;

    public function selectContentElement(string $contentElement): void;

    public function addTextareaContentElementWithContent(string $content): void;

    public function addSingleMediaContentElementWithName(string $name): void;

    public function addMultipleMediaContentElementWithNames(array $mediaNames): void;

    public function addHeadingContentElementWithTypeAndContent(string $type, string $content): void;

    public function addProductsCarouselContentElementWithProducts(array $productsNames): void;

    public function addProductsCarouselByTaxonContentElementWithTaxon(string $taxon): void;

    public function addProductsGridContentElementWithProducts(array $productsNames): void;

    public function addProductsGridByTaxonContentElementWithTaxon(string $taxon): void;

    public function addTaxonsListContentElementWithTaxons(array $taxons): void;

    public function selectTemplate(string $templateName): void;

    public function useTemplate(): void;

    public function confirmUseTemplate(): void;
}
