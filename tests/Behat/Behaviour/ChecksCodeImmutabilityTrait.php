<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);


namespace Tests\BitBag\CmsPlugin\Behat\Behaviour;

use Sylius\Behat\Behaviour\DocumentAccessor;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
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
