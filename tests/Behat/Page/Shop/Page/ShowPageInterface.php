<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
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
}
