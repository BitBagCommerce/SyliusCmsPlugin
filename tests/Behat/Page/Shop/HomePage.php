<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Page\Shop;

use Sylius\Behat\Page\Shop\HomePage as BaseHomePage;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
class HomePage extends BaseHomePage implements HomePageInterface
{
    /**
     * {@inheritdoc}
     */
    public function hasImageBlock(): bool
    {
        return $this->getElement('image_block')->has('css','img');
    }

    /**
     * {@inheritdoc}
     */
    public function hasBlockWithContent(string $content): bool
    {
        return $content === $this->getElement('content')->getText();
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'image_block' => '.bitbag-image-block',
            'content' => '.bitbag-block p',
        ]);
    }
}
