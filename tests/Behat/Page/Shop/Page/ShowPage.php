<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Shop\Page;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\SymfonyPage;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShowPage extends SymfonyPage implements ShowPageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'bitbag_sylius_cms_plugin_shop_page_show';
    }

    /**
     * {@inheritdoc}
     */
    public function hasName(string $name): bool
    {
        return $name === $this->getElement('name')->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function hasContent(string $content): bool
    {
        return $content === $this->getElement('content')->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function hasProducts(array $productsNames): bool
    {
        $productsOnPage = $this->getElement('products')->findAll('css', '.sylius-product-name');

        /** @var NodeElement $productOnPage */
        foreach ($productsOnPage as $productOnPage) {
            if (false === in_array($productOnPage->getText(), $productsNames)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function hasSections(array $sectionNames): bool
    {
        $sectionsOnPage = $this->getElement('sections')->findAll('css', 'a');

        /** @var NodeElement $sectionOnPage */
        foreach ($sectionsOnPage as $sectionOnPage) {
            if (false === in_array($sectionOnPage->getText(), $sectionNames)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPageLink(string $linkName): bool
    {
        return $linkName === $this->getElement('link')->getText();
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'name' => '.bitbag-page-name',
            'content' => '.bitbag-page-content',
            'products' => '.bitbag-page-products',
            'sections' => '.bitbag-page-sections',
            'link' => '.bitbag-page-link',
        ]);
    }
}
