<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Shop\Page;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class IndexPage extends SymfonyPage implements IndexPageInterface
{
    public function getRouteName(): string
    {
        return 'sylius_cms_plugin_shop_page_index_by_collection_code';
    }

    public function hasCollectionName(string $collectionName): bool
    {
        return $collectionName === $this->getElement('collection')->getText();
    }

    public function hasPagesNumber(int $pagesNumber): bool
    {
        $pagesNumberOnPage = count($this->getElement('pages')->findAll('css', '.bitbag-page'));

        return $pagesNumber === $pagesNumberOnPage;
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'collection' => '.bitbag-collection-name',
            'pages' => '#bitbag-pages',
        ]);
    }
}
