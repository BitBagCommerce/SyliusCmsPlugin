<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Shop;

use Sylius\Behat\Page\Shop\HomePageInterface as BaseHomePageInterface;

interface HomePageInterface extends BaseHomePageInterface
{
    public function hasImageBlock(): bool;

    public function hasBlockWithContent(string $content): bool;
}
