<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

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
    public function uploadImage($image)
    {
        $this->getDocument()
            ->attachFileToField('Choose file', __DIR__ . '/../Resources/images/' . $image)
        ;
    }

    /**
     * @param string $name
     */
    public function fillName($name)
    {
        $this->getDocument()->fillField('Name', $name);
    }

    /**
     * @param string $link
     */
    public function fillLink($link)
    {
        $this->getDocument()->fillField('Link', $link);
    }

    /**
     * @param string $content
     */
    public function fillContent($content)
    {
        $this->getDocument()->fillField('Content', $content);
    }

    public function disable()
    {
        $this->getDocument()->uncheckField('Enabled');
    }
}