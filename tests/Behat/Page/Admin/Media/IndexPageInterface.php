<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Media;

use Sylius\Behat\Page\Admin\Crud\IndexPageInterface as BaseIndexPageInterface;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsEmptyListInterface;

interface IndexPageInterface extends BaseIndexPageInterface, ContainsEmptyListInterface
{
    public function deleteMedia(string $code): void;
}
