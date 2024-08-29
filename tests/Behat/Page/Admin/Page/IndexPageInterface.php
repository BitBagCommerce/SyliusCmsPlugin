<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Page;

use Sylius\Behat\Page\Admin\Crud\IndexPageInterface as BaseIndexPageInterface;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsEmptyListInterface;

interface IndexPageInterface extends BaseIndexPageInterface, ContainsEmptyListInterface
{
    public function deletePage(string $code): void;
}
