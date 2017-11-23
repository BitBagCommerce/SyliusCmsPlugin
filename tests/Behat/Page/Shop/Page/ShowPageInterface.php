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

use Sylius\Behat\Page\SymfonyPageInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface ShowPageInterface extends SymfonyPageInterface
{
    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasName(string $name): bool;

    /**
     * @param string $content
     *
     * @return bool
     */
    public function hasContent(string $content): bool;

    /**
     * @param array $productsNames
     *
     * @return bool
     */
    public function hasProducts(array $productsNames): bool;

    /**
     * @param array $sectionNames
     *
     * @return bool
     */
    public function hasSections(array $sectionNames): bool;

    /**
     * @param string $linkName
     *
     * @return bool
     */
    public function hasPageLink(string $linkName): bool;
}
