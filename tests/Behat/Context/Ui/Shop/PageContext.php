<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\Sylius\CmsPlugin\Behat\Page\Shop\Page\IndexPageInterface;
use Tests\Sylius\CmsPlugin\Behat\Page\Shop\Page\ShowPageInterface;
use Webmozart\Assert\Assert;

final class PageContext implements Context
{
    public function __construct(
        private ShowPageInterface $showPage,
        private IndexPageInterface $indexPage,
        private SharedStorageInterface $sharedStorage,
    ) {
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
     * @When I go to the collection pages list for the :collectionCode collection
     */
    public function iGoToTheCollectionPagesListForTheCollection(string $collectionCode): void
    {
        $this->indexPage->open(['collectionCode' => $collectionCode]);
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
     * @Then I should also see :firstCollectionName and :secondCollectionName collections associated with this page
     */
    public function iShouldAlsoSeeCollectionsAssociatedWithThisPage(string ...$collectionsNames): void
    {
        Assert::true($this->showPage->hasCollections($collectionsNames));
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

    /**
     * @Then The rendered page should contain custom layout code
     */
    public function theRenderedPageShouldContainCustomLayoutCode()
    {
        Assert::true($this->showPage->hasCustomLayoutCode());
    }
}
