<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Context\Api;

use Behat\Behat\Context\Context;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Tests\Sylius\CmsPlugin\Behat\Resources;
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
