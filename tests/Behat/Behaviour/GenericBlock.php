<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Behaviour;

use Sylius\Behat\Behaviour\DocumentAccessor;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
trait GenericBlock
{
    use DocumentAccessor;

    /**
     * @param string $image
     */
    public function uploadImage(string $image): void
    {
        $this->getDocument()
            ->attachFileToField('Choose file', __DIR__ . '/../Resources/images/' . $image)
        ;
    }

    /**
     * @param string $name
     */
    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);
    }

    /**
     * @param string $link
     */
    public function fillLink(string $link): void
    {
        $this->getDocument()->fillField('Link', $link);
    }

    /**
     * @param string $content
     */
    public function fillContent(string $content): void
    {
        $this->getDocument()->fillField('Content', $content);
    }

    public function disable(): void
    {
        $this->getDocument()->uncheckField('Enabled');
    }
}