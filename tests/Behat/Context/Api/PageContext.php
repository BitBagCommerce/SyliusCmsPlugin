<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Context\Api;

use Behat\Behat\Context\Context;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Sylius\Bundle\CoreBundle\Application\Kernel as SyliusKernel;
use Sylius\CmsPlugin\Entity\PageInterface;
use Tests\Sylius\CmsPlugin\Behat\Resources;
use Webmozart\Assert\Assert;

final class PageContext implements Context
{
    public function __construct(
        private ApiClientInterface $apiClient,
        private ResponseCheckerInterface $responseChecker,
    ) {
    }

    /**
     * @When /^I want to browse pages$/
     */
    public function iWantToBrowsePages(): void
    {
        $this->apiClient->index(Resources::PAGES);
    }

    /**
     * @Then /^I should see (\d+) page(?:s)? in the list$/
     */
    public function iShouldSeePageInTheList(int $count): void
    {
        Assert::count(
            $this->responseChecker->getCollection(
                $this->apiClient->getLastResponse(),
            ),
            $count,
            sprintf('There is no page with name "%s"', $count),
        );
    }

    /**
     * @Then /^I should see the "([^"]*)" page$/
     */
    public function iShouldSeeThePage(string $page): void
    {
        Assert::true(
            $this->responseChecker->hasItemWithValue(
                $this->apiClient->index(Resources::PAGES),
                'name',
                $page,
            ),
            sprintf('There is no page with name "%s"', $page),
        );
    }

    /**
     * @When I view page with code :page
     */
    public function iOpenPage(PageInterface $page): void
    {
        if (SyliusKernel::MINOR_VERSION === '11') {
            $this->apiClient->show((string) $page->getId());
        } else {
            $this->apiClient->show(Resources::PAGES, (string) $page->getId());
        }
    }

    /**
     * @Then /^I should see the page name "([^"]*)"$/
     */
    public function iShouldSeeThePageName(string $name): void
    {
        Assert::true(
            $this->responseChecker->hasValue(
                $this->apiClient->getLastResponse(),
                'name',
                $name,
            ),
            sprintf('There is no page with name "%s"', $name),
        );
    }

    /**
     * @Then /^I should see the page content "([^"]*)"$/
     */
    public function iShouldSeeThePageContent(string $content): void
    {
        Assert::true(
            $this->responseChecker->hasItemWithTranslation(
                $this->apiClient->getLastResponse(),
                'en_US',
                'content',
                $content,
            ),
            sprintf('There is no page with content "%s"', $content),
        );
    }
}
