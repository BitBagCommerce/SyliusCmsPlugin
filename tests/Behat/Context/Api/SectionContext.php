<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Api;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Webmozart\Assert\Assert;

final class SectionContext implements Context
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
     * @Given /^I want to browse sections$/
     */
    public function iWantToBrowseSections(): void
    {
        $this->apiClient->index();
    }

    /**
     * @Then /^I should see (\d+) sections in the list$/
     */
    public function iShouldSeeSectionsInTheList(int $count): void
    {
        Assert::count($this->responseChecker->getCollection(
            $this->apiClient->getLastResponse()),
            $count
        );
    }

    /**
     * @Then I should see section with code :section
     * @Given I view section with code :section
     */
    public function iShouldSeeSectionWithCode(SectionInterface $section): void
    {
        $this->apiClient->show((string)$section->getId());
    }

    /**
     * @Then /^I should see section name$/
     */
    public function iShouldSeeSectionName(): void
    {
        Assert::false(
            $this->responseChecker->hasTranslation(
                $this->apiClient->getLastResponse(),
                "en_US",
                "name",
                "That shouldn't exist"
            ), "Section has missing name"
        );
    }
}
