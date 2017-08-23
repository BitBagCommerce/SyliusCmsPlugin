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
trait Block
{
    use DocumentAccessor;

    /**
     * @param string $code
     */
    public function fillCode($code)
    {
        $this->getDocument()->fillField('Code', $code);
    }

    /**
     * @param string $image
     */
    public function uploadImage($image)
    {
        $this->getDocument()
            ->attachFileToField('Image', __DIR__ . '/../Resources/images/' . $image)
        ;
    }

    /**
     * @param string $content
     */
    public function fillContent($content)
    {
        $this->getDocument()->fillField('Content', $content);
    }
}