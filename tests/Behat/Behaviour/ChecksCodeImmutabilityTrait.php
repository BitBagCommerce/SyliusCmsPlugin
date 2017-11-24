<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour;

use Sylius\Behat\Behaviour\DocumentAccessor;

trait ChecksCodeImmutabilityTrait
{
    use DocumentAccessor;

    /**
     * @return bool
     */
    public function isCodeDisabled(): bool
    {
        return 'disabled' === $this->getDocument()->findField('Code')->getAttribute('disabled');
    }
}
