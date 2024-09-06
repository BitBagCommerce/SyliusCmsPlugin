<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Behaviour;

interface ContainsEmptyListInterface
{
    public function isEmpty(): bool;
}
