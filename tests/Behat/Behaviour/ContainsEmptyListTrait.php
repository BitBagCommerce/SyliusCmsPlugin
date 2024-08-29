<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Behaviour;

use Sylius\Behat\Behaviour\DocumentAccessor;

trait ContainsEmptyListTrait
{
    use DocumentAccessor;

    public function isEmpty(): bool
    {
        return false !== strpos($this->getDocument()->find('css', '.message')->getText(), 'There are no results to display');
    }
}
