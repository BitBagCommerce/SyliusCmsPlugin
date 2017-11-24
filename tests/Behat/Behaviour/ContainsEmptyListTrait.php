<?php

/**
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour;

use Sylius\Behat\Behaviour\DocumentAccessor;

trait ContainsEmptyListTrait
{
    use DocumentAccessor;

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return false !== strpos($this->getDocument()->find('css', '.message')->getText(), 'There are no results to display');
    }
}
