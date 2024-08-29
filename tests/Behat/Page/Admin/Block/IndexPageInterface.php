<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Block;

use Sylius\Behat\Page\Admin\Crud\IndexPageInterface as BaseIndexPageInterface;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsEmptyListInterface;

interface IndexPageInterface extends BaseIndexPageInterface, ContainsEmptyListInterface
{
    public function getBlocksWithTypeCount(string $type): int;

    public function deleteBlock(string $code): void;
}
