<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Behaviour;

use Sylius\Behat\Behaviour\DocumentAccessor;

trait ChecksCodeImmutabilityTrait
{
    use DocumentAccessor;

    public function isCodeDisabled(): bool
    {
        return 'disabled' === $this->getDocument()->findField('Code')->getAttribute('disabled');
    }
}
