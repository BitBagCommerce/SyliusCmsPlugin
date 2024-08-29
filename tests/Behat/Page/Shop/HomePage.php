<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Shop;

use Sylius\Behat\Page\Shop\HomePage as BaseHomePage;

class HomePage extends BaseHomePage implements HomePageInterface
{
    public function hasImageBlock(): bool
    {
        return $this->getElement('image_block')->has('css', 'img');
    }

    public function hasBlockWithContent(string $content): bool
    {
        return $content === $this->getElement('content')->getText();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'image_block' => '.bitbag-image-block',
            'content' => '.bitbag-block',
        ]);
    }
}
