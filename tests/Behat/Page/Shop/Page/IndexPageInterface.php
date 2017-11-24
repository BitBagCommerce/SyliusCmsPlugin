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

use Sylius\Behat\Page\SymfonyPageInterface;

interface IndexPageInterface extends SymfonyPageInterface
{
    /**
     * @param string $sectionName
     *
     * @return bool
     */
    public function hasSectionName(string $sectionName): bool;

    /**
     * @param int $pagesNumber
     *
     * @return bool
     */
    public function hasPagesNumber(int $pagesNumber): bool;
}
