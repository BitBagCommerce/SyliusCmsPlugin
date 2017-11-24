<?php

/**
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);


namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Shop;

use Sylius\Behat\Page\Shop\HomePageInterface as BaseHomePageInterface;

interface HomePageInterface extends BaseHomePageInterface
{
    /**
     * @return bool
     */
    public function hasImageBlock(): bool;

    /**
     * @param string $content
     *
     * @return bool
     */
    public function hasBlockWithContent(string $content): bool;
}
