<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Shop\Page;

use Behat\Mink\Element\NodeElement;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ShowPage extends SymfonyPage implements ShowPageInterface
{
    public function getRouteName(): string
    {
        return 'sylius_cms_shop_page_show';
    }

    public function hasName(string $name): bool
    {
        return $name === $this->getElement('name')->getText();
    }

    public function hasContent(string $content): bool
    {
        return $content === $this->getElement('content')->getText();
    }

    public function hasProducts(array $productsNames): bool
    {
        $productsOnPage = $this->getElement('products')->findAll('css', '.sylius-product-name');

        /** @var NodeElement $productOnPage */
        foreach ($productsOnPage as $productOnPage) {
            if (false === in_array($productOnPage->getText(), $productsNames, true)) {
                return false;
            }
        }

        return true;
    }

    public function hasCollections(array $collectionNames): bool
    {
        $collectionsOnPage = $this->getElement('collections')->findAll('css', 'a');

        /** @var NodeElement $collectionOnPage */
        foreach ($collectionsOnPage as $collectionOnPage) {
            if (false === in_array($collectionOnPage->getText(), $collectionNames, true)) {
                return false;
            }
        }

        return true;
    }

    public function hasPageLink(string $linkName): bool
    {
        return $linkName === $this->getElement('link')->getText();
    }

    public function hasPageImage(): bool
    {
        return $this->getElement('page-image')->isVisible();
    }

    public function hasTitle(string $title): bool
    {
        return $this->getSession()->evaluateScript('return document.title') === $title;
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'name' => '.cms-page-name',
            'content' => '.cms-page-content',
            'products' => '.cms-page-products',
            'collections' => '.cms-page-collections',
            'link' => '.cms-page-link',
            'page-image' => '.page-image',
        ]);
    }
}
