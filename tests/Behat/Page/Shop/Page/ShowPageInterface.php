<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Shop\Page;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ShowPageInterface extends SymfonyPageInterface
{
    public function hasName(string $name): bool;

    public function hasContent(string $content): bool;

    public function hasProducts(array $productsNames): bool;

    public function hasSections(array $sectionNames): bool;

    public function hasPageLink(string $linkName): bool;

    public function hasPageImage(): bool;

    public function hasTitle(string $title): bool;
}
