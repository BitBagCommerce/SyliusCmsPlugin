<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Block;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    public function fillField(string $field, string $value): void;

    public function fillCode(string $code): void;

    public function fillName(string $name): void;

    public function fillNameIfItIsEmpty(string $name): void;

    public function fillLink(string $link): void;

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

    public function disable(): void;
}
