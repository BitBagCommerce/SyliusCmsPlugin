<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
