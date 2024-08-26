<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Context\Api;

use Behat\Behat\Context\Context;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Tests\Sylius\CmsPlugin\Behat\Resources;
use Webmozart\Assert\Assert;

final class MediaContext implements Context
{
    public function __construct(
        private ApiClientInterface $apiClient,
        private ResponseCheckerInterface $responseChecker,
    ) {
    }

    /**
     * @Given /^I want to browse media$/
     */
    public function iWantToBrowseMedia(): void
    {
        $this->apiClient->index(Resources::MEDIA);
    }

    /**
     * @Then /^I should see (\d+) media in the list$/
     */
    public function iShouldSeeMediaInTheList(int $count): void
    {
        Assert::count(
            $this->responseChecker->getCollection(
                $this->apiClient->getLastResponse(),
            ),
            $count,
        );
    }

    /**
     * @Given I view media with code :media
     * @Then I should see media with code :media
     */
    public function iShouldSeeTheMedia(MediaInterface $media): void
    {
        $this->apiClient->show(Resources::MEDIA, (string) $media->getId());
    }

    /**
     * @Then /^I should see media name$/
     */
    public function iShouldSeeMediaName(): void
    {
        Assert::false(
            $this->responseChecker->hasTranslation(
                $this->apiClient->getLastResponse(),
                'en_US',
                'content',
                "That shouldn't exist",
            ),
            'Missing media',
        );
    }
}
