<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\CmsPlugin\Behat\Page\Shop\Page\ShowPageInterface;
use Tests\BitBag\CmsPlugin\Behat\Page\Shop\Page\IndexPageInterface;
use Webmozart\Assert\Assert;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class PageContext implements Context
{
    /**
     * @var ShowPageInterface
     */
    private $showPage;

    /**
     * @var IndexPageInterface
     */
    private $indexPage;

    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @param ShowPageInterface $showPage
     * @param IndexPageInterface $indexPage
     * @param SharedStorageInterface $sharedStorage
     */
    public function __construct(
        ShowPageInterface $showPage, 
        IndexPageInterface $indexPage,
        SharedStorageInterface $sharedStorage
    )
    {
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
}
