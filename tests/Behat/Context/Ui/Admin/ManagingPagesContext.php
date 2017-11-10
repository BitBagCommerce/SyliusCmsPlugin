<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use BitBag\CmsPlugin\Entity\PageInterface;
use BitBag\CmsPlugin\Repository\PageRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Page\SymfonyPageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\CmsPlugin\Behat\Behaviour\ContainsError;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Page\CreatePageInterface;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Page\IndexPageInterface;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Page\UpdatePageInterface;
use Tests\BitBag\CmsPlugin\Behat\Service\RandomStringGeneratorInterface;
use Webmozart\Assert\Assert;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ManagingPagesContext implements Context
{
    /**
     * @var IndexPageInterface
     */
    private $indexPage;

    /**
     * @var CreatePageInterface
     */
    private $createPage;

    /**
     * @var UpdatePageInterface
     */
    private $updatePage;

    /**
     * @var CurrentPageResolverInterface
     */
    private $currentPageResolver;

    /**
     * @var NotificationCheckerInterface
     */
    private $notificationChecker;

    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var RandomStringGeneratorInterface
     */
    private $randomStringGenerator;

    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param IndexPageInterface $indexPage
     * @param CreatePageInterface $createPage
     * @param UpdatePageInterface $updatePage
     * @param CurrentPageResolverInterface $currentPageResolver
     * @param NotificationCheckerInterface $notificationChecker
     * @param SharedStorageInterface $sharedStorage
     * @param RandomStringGeneratorInterface $randomStringGenerator
     * @param PageRepositoryInterface $pageRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        IndexPageInterface $indexPage,
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage,
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        SharedStorageInterface $sharedStorage,
        RandomStringGeneratorInterface $randomStringGenerator,
        PageRepositoryInterface $pageRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->indexPage = $indexPage;
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->sharedStorage = $sharedStorage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->pageRepository = $pageRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @When I go to the cms pages page
     */
    public function iGoToTheCmsPagesPage(): void
    {
        $this->indexPage->open();
    }

    /**
     * @When I go to the create new page page
     */
    public function iGoToTheCreateNewPagePage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I go to the update :code page page
     */
    public function iGoToTheUpdatePagePage(string $code): void
    {
        $page = $this->pageRepository->findOneBy(['code' => $code]);

        Assert::notNull($page);

        $this->sharedStorage->set('page_code', $code);

        $this->updatePage->open(['id' => $page->getId()]);
    }

    /**
     * @When I fill the code with :code
     */
    public function iFillTheCodeWith(string $code): void
    {
        $this->resolveCurrentPage()->fillCode($code);

        $this->sharedStorage->set('page_code', $code);
    }

    /**
     * @When I fill the name with :name
     */
    public function iFillTheNameWith(string $name): void
    {
        $this->resolveCurrentPage()->fillName($name);
    }

    /**
     * @When I fill the link with :link
     */
    public function iFillTheLinkWith(string $link): void
    {
        $this->resolveCurrentPage()->fillLink($link);
    }

    /**
     * @When I fill the slug with :slug
     */
    public function iFillTheSlugWith(string $slug): void
    {
        $this->resolveCurrentPage()->fillSlug($slug);
    }

    /**
     * @When I fill the meta keywords with :metaKeywords
     */
    public function iFillTheMetaKeywordsWith(string $metaKeywords): void
    {
        $this->resolveCurrentPage()->fillMetaKeywords($metaKeywords);
    }

    /**
     * @When I fill the meta description with :metaDescription
     */
    public function iFillTheMetaDescriptionWith(string $metaDescription): void
    {
        $this->resolveCurrentPage()->fillMetaDescription($metaDescription);
    }

    /**
     * @When I fill the content with :content
     */
    public function iFillTheContentWith(string $content): void
    {
        $this->resolveCurrentPage()->fillContent($content);
    }

    /**
     * @When /^I fill "([^"]*)" with (\d+) (?:character|characters)$/
     */
    public function iFillWithCharacter(string $fields, int $length): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            $this->resolveCurrentPage()->fillField(trim($field), $this->randomStringGenerator->generate($length));
        }
    }

    /**
     * @When I add it
     * @When I try to add it
     */
    public function iAddIt(): void
    {
        $this->resolveCurrentPage()->create();
    }

    /**
     * @When I update it
     */
    public function iUpdateIt(): void
    {
        $this->resolveCurrentPage()->saveChanges();
    }

    /**
     * @When I remove last page
     */
    public function iRemoveLastPage(): void
    {
        $code = $this->sharedStorage->get('page')->getCode();

        $this->indexPage->deleteResourceOnPage(['code' => $code]);
    }

    /**
     * @Then I should be notified that new page was created
     */
    public function iShouldBeNotifiedThatNewPageWasCreated(): void
    {
        $this->notificationChecker->checkNotification(
            "Page has been successfully created.",
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that the page was updated
     */
    public function iShouldBeNotifiedThatThePageWasUpdated(): void
    {
        $this->notificationChecker->checkNotification(
            "Page has been successfully updated.",
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that this page was removed
     */
    public function iShouldBeNotifiedThatThisPageWasRemoved(): void
    {
        $this->notificationChecker->checkNotification(
            "Page has been successfully deleted.",
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that :fields fields can not be blank
     */
    public function iShouldBeNotifiedThatFieldsCanNotBeBlank(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                "%s can not be blank.",
                trim($field)
            )));
        }
    }

    /**
     * @Then I should be notified that the :fields fields are too short
     */
    public function iShouldBeNotifiedThatTheFieldsAreTooShort(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                "%s must be at least %d characters long.",
                trim($field), 2
            )));
        }
    }

    /**
     * @Then I should be notified that :fields fields are too long
     */
    public function iShouldBeNotifiedThatFieldsAreTooLong(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                "%s can not be longer than",
                trim($field)
            ), false));
        }
    }

    /**
     * @Then this page should have :code code
     */
    public function thisPageShouldHaveCode(string $code): void
    {
        Assert::eq($code, $this->getPage()->getCode());
    }

    /**
     * @Then it should have :name name
     */
    public function itShouldHaveName(string $name): void
    {
        Assert::eq($this->getPage()->getName(), $name);
    }

    /**
     * @Then it should have :slug slug
     */
    public function itShouldHaveSlug(string $slug): void
    {
        Assert::eq($this->getPage()->getSlug(), $slug);
    }

    /**
     * @Then it should have :metaKeywords meta keywords
     */
    public function itShouldHaveMetaKeywords(string $metaKeywords): void
    {
        Assert::eq($metaKeywords, $this->getPage()->getMetaKeywords());
    }

    /**
     * @Then it should have :content content
     */
    public function itShouldHaveContent(string $content): void
    {
        Assert::eq($content, $this->getPage()->getContent());
    }

    /**
     * @Then :number pages should exist in the store
     */
    public function pagesShouldExistInTheStore(int $number): void
    {
        Assert::eq((int)$number, count($this->pageRepository->findAll()));
    }

    /**
     * @return CreatePageInterface|UpdatePageInterface|ContainsError|SymfonyPageInterface
     */
    private function resolveCurrentPage(): SymfonyPageInterface
    {
        return $this->currentPageResolver->getCurrentPageWithForm([$this->createPage, $this->updatePage]);
    }

    /**
     * @return null|PageInterface
     */
    private function getPage(): ?PageInterface
    {
        $code = $this->sharedStorage->get('page_code');
        /** @var null|PageInterface $page */
        $page = $this->pageRepository->findOneBy(['code' => $code]);

        $this->entityManager->refresh($page->getTranslation());

        Assert::notNull($page);

        return $page;
    }
}