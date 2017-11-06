<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\CmsPlugin\Behat\Service;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface RandomStringGeneratorInterface
{
    /**
     * @param int $length
     *
     * @return string
     */
    public function generate(int $length = 10): string;
}