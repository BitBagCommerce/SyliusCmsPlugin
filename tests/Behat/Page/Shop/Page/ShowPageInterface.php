<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Shop\Page;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ShowPageInterface extends SymfonyPageInterface
{
    public function hasName(string $name): bool;

    public function hasContent(string $content): bool;

    public function hasProducts(array $productsNames): bool;

    public function hasCollections(array $collectionNames): bool;

    public function hasPageLink(string $linkName): bool;

    public function hasPageImage(): bool;

    public function hasTitle(string $title): bool;

    public function hasCustomLayoutCode(): bool;
}
