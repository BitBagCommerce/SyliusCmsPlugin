<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Api;

use Behat\Behat\Context\Context;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Webmozart\Assert\Assert;

final class BlockContext implements Context
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
     * @Given /^I want to browse blocks$/
     */
    public function iWantToBrowseBlocks(): void
    {
        $this->apiClient->index();
    }

    /**
     * @Then /^I should see (\d+) blocks in the list$/
     */
    public function iShouldSeeBlocksInTheList(int $count): void
    {
        Assert::count($this->responseChecker->getCollection(
            $this->apiClient->getLastResponse()),
            $count
        );
    }

    /**
     * @Then I should see block with code :block
     * @Given I view block with code :block
     */
    public function iShouldSeeBlockWithCode(string $code): void
    {
        Assert::true(
            $this->responseChecker->hasItemWithValue(
                $this->apiClient->index(),
                "code",
                $code
            ),
            sprintf('There is no blocks with code "%s"', $code)
        );
    }

    /**
     * @Then /^I should see block name$/
     */
    public function iShouldSeeBlockName(): void
    {
        Assert::false(
            $this->responseChecker->hasTranslation(
                $this->apiClient->getLastResponse(),
                "en_US",
                "answer",
                "That shouldn't exist"
            ), "Block has missing name"
        );
    }

    /**
     * @Then /^I should see block content$/
     */
    public function iShouldSeeBlockContent(): void
    {
        Assert::true(
            $this->responseChecker->hasItemWithTranslation(
                $this->apiClient->getLastResponse(),
                "en_US",
                "content",
                "Hi there!"
            ), "Block has missing content"
        );
    }
}
