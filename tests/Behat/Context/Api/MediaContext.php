<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Api;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Webmozart\Assert\Assert;

final class MediaContext implements Context
{
    private $apiClient;

    private $responseChecker;

    public function __construct(
        ApiClientInterface $apiClient,
        ResponseCheckerInterface $responseChecker
    ) {
        $this->apiClient = $apiClient;
        $this->responseChecker = $responseChecker;
    }

    /**
     * @Given /^I want to browse media$/
     */
    public function iWantToBrowseMedia(): void
    {
        $this->apiClient->index();
    }

    /**
     * @Then /^I should see (\d+) media in the list$/
     */
    public function iShouldSeeMediaInTheList(int $count): void
    {
        Assert::count(
            $this->responseChecker->getCollection(
                $this->apiClient->getLastResponse()
            ),
            $count
        );
    }

    /**
     * @Then I should see media with code :media
     * @Given I view media with code :media
     */
    public function iShouldSeeTheMedia(MediaInterface $media): void
    {
        $this->apiClient->show((string) $media->getId());
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
                "That shouldn't exist"
            ),
            'Missing media'
        );
    }
}
