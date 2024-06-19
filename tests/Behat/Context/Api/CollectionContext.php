<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Api;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Resources;
use Webmozart\Assert\Assert;

final class CollectionContext implements Context
{
    public function __construct(
        private ApiClientInterface $apiClient,
        private ResponseCheckerInterface $responseChecker,
    ) {
    }

    /**
     * @Given /^I want to browse collections$/
     */
    public function iWantToBrowseCollections(): void
    {
        $this->apiClient->index(Resources::COLLECTIONS);
    }

    /**
     * @Then /^I should see (\d+) collections in the list$/
     */
    public function iShouldSeeCollectionsInTheList(int $count): void
    {
        Assert::count(
            $this->responseChecker->getCollection(
                $this->apiClient->getLastResponse(),
            ),
            $count,
        );
    }

    /**
     * @Given I view collection with code :collection
     * @Then I should see collection with code :collection
     */
    public function iShouldSeeCollectionWithCode(CollectionInterface $collection): void
    {
        $this->apiClient->show(Resources::COLLECTIONS, (string) $collection->getId());
    }

    /**
     * @Then /^I should see collection name$/
     */
    public function iShouldSeeCollectionName(): void
    {
        Assert::false(
            $this->responseChecker->hasTranslation(
                $this->apiClient->getLastResponse(),
                'en_US',
                'name',
                "That shouldn't exist",
            ),
            'Collection has missing name',
        );
    }
}
