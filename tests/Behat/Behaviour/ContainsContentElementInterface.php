<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Behaviour;

interface ContainsContentElementInterface
{
    public function containsContentElement(string $contentElement): bool;
}
