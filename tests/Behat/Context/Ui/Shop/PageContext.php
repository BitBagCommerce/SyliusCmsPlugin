<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Shop\Page\IndexPageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Shop\Page\ShowPageInterface;
use Webmozart\Assert\Assert;

final class PageContext implements Context
{
    /** @var ShowPageInterface */
    private $showPage;

    /** @var IndexPageInterface */
    private $indexPage;

    /** @var SharedStorageInterface */
    private $sharedStorage;

    public function __construct(
        ShowPageInterface $showPage,
        IndexPageInterface $indexPage,
        SharedStorageInterface $sharedStorage
    ) {
        $this->showPage = $showPage;
        $this->indexPage = $indexPage;
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @When I go to the :slug page
     */
    public function iGoToThePage(string $slug): void
    {
        $this->showPage->open(['slug' => $slug]);
    }

    /**
     * @When I go to this page
     */
    public function iGoToThisPage(): void
    {
        $slug = $this->sharedStorage->get('page')->getSlug();

        $this->showPage->open(['slug' => $slug]);
    }

    /**
     * @When I go to the section pages list for the :sectionCode section
     */
    public function iGoToTheSectionPagesListForTheSection(string $sectionCode): void
    {
        $this->indexPage->open(['sectionCode' => $sectionCode]);
    }

    /**
     * @Then I should see a page with :name name
     */
    public function iShouldSeeAPageWithName(string $name): void
    {
        Assert::true($this->showPage->hasName($name));
    }

    /**
     * @Then I should also see :content content
     */
    public function iShouldAlsoSeeContent(string $content): void
    {
        Assert::true($this->showPage->hasContent($content));
    }

    /**
     * @Then I should also see page image
     */
    public function iShouldAlsoSeeImage(): void
    {
        Assert::true($this->showPage->hasPageImage());
    }

    /**
     * @Then I should also see :firstProductName and :secondProductName products associated with this page
     */
    public function iShouldAlsoSeeProductsAssociatedWithThisPage(string ...$productsNames): void
    {
        Assert::true($this->showPage->hasProducts($productsNames));
    }

    /**
     * @Then I should also see :firstSectionName and :secondSectionName sections associated with this page
     */
    public function iShouldAlsoSeeSectionsAssociatedWithThisPage(string ...$sectionsNames): void
    {
        Assert::true($this->showPage->hasSections($sectionsNames));
    }

    /**
     * @Then I should see the :linkName page link in the header
     */
    public function iShouldSeePageLinkOnThePageInTheHeader(string $linkName): void
    {
        Assert::true($this->showPage->hasPageLink($linkName));
    }

    /**
     * @Then I should see :pagesNumber pages on the page
     */
    public function iShouldSeePagesOnThePage(int $pagesNumber): void
    {
        Assert::true($this->indexPage->hasPagesNumber($pagesNumber));
    }

    /**
     * @Then I should see page title :title
     */
    public function iShouldSeePageTitle(string $title): void
    {
        Assert::true($this->showPage->hasTitle($title));
    }
}
