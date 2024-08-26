<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
