<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Behat\Mink\Element\DocumentElement;
use Behat\MinkExtension\Context\RawMinkContext;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;

class MediaContext extends RawMinkContext implements Context
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepository,
    ) {
    }

    /**
     * @When I want to see a media with code :arg1
     */
    public function iWantToSeeAMedia(string $arg1): void
    {
        $media = $this->mediaRepository->findOneBy(['code' => $arg1]);

        $xpath = "//img[@src='" . $media->getPath() . "']";
        $this->getPage()->find('xpath', $xpath)->getParent();
    }

    private function getPage(): DocumentElement
    {
        return $this->getSession()->getPage();
    }
}
