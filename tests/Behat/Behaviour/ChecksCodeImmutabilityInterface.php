<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Behaviour;

interface ChecksCodeImmutabilityInterface
{
    public function isCodeDisabled(): bool;
}
