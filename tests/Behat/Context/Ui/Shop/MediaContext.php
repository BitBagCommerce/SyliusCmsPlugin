<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Behat\Mink\Element\DocumentElement;
use Behat\MinkExtension\Context\RawMinkContext;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Shop\HomePageInterface;
use Webmozart\Assert\Assert;

class MediaContext extends RawMinkContext implements Context
{
    /** @var MediaRepositoryInterface */
    private $mediaRepository;

    /** @var HomePageInterface */
    private $blockHomePage;

    public function __construct(
        MediaRepositoryInterface $mediaRepository,
        HomePageInterface $blockHomePage
    ) {
        $this->mediaRepository = $mediaRepository;
        $this->blockHomePage = $blockHomePage;
    }

    /**
     * @When I want to see a media with code :arg1
     */
    public function iWantToSeeAMedia(string $arg1)
    {
        $media = $this->mediaRepository->findOneBy(['code' => $arg1]);

        $xpath = "//img[@src='".$media->getPath()."']";
        $this->getPage()->find('xpath', $xpath)->getParent();
    }

    /**
     * @return DocumentElement
     */
    private function getPage()
    {
        return $this->getSession()->getPage();
    }
}