<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Api;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Webmozart\Assert\Assert;

final class PageContext implements Context
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
     * @When /^I want to browse pages$/
     */
    public function iWantToBrowsePages(): void
    {
        $this->apiClient->index();
    }

    /**
     * @Then /^I should see (\d+) page(?:s)? in the list$/
     */
    public function iShouldSeePageInTheList($count): void
    {
        Assert::count($this->responseChecker->getCollection(
            $this->apiClient->getLastResponse()),
            $count
        );
    }

    /**
     * @Then /^I should see the "([^"]*)" page$/
     */
    public function iShouldSeeThePage($page): void
    {
        Assert::true(
            $this->responseChecker->hasItemWithTranslation(
                $this->apiClient->index(),
                "en_US",
                'name',
                $page
            ),
            sprintf('There is no page with name "%s"', $page)
        );
    }

    /**
     * @When I view page with code :page
     */
    public function iOpenPage(PageInterface $page): void
    {
        $this->apiClient->show((string)$page->getId());
    }

    /**
     * @Then /^I should see the page name "([^"]*)"$/
     */
    public function iShouldSeeThePageName($name): void
    {
        Assert::true(
            $this->responseChecker->hasItemWithTranslation(
                $this->apiClient->getLastResponse(),
                'en_US',
                'name',
                $name
            )
        );
    }

    /**
     * @Then /^I should see the page content "([^"]*)"$/
     */
    public function iShouldSeeThePageContent($content): void
    {
        Assert::true(
            $this->responseChecker->hasItemWithTranslation(
                $this->apiClient->getLastResponse(),
                'en_US',
                'content',
                $content
            )
        );
    }
}
