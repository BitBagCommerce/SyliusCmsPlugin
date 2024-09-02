<?php

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
