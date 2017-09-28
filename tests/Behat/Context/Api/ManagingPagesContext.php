<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\CmsPlugin\Behat\Context\Api\Admin;

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
use Tests\BitBag\CmsPlugin\Behat\Behaviour\GenericPage;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Page\CreatePageInterface;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Page\IndexPageInterface;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Page\UpdatePageInterface;
use Tests\BitBag\CmsPlugin\Behat\Service\RandomStringGeneratorInterface;
use Webmozart\Assert\Assert;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ManagingPagesApiContext implements Context
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
     * @var Client
     */
    private $client;

    /**
     * @var SessionInterface
     */
    private $session;

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
     * @param Client $client
     * @param SessionInterface $session
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
        EntityManagerInterface $entityManager,
        Client $client,
        SessionInterface $session
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
        $this->client = $client;
        $this->session = $session;
    }

    /**
     * @When I go to the cms pages page
     */
    public function iGoToTheCmsPagesPage()
    {
        $this->client->getCookieJar()->set(new Cookie($this->session->getName(), $this->session->getId()));
        $this->client->request('GET', '/api/pages', [], [], ['ACCEPT' => 'application/json']);
    }

    /**
     * @When I go to the create new page page
     */
    public function iGoToTheCreateNewPagePage()
    {
        $this->client->getCookieJar()->set(new Cookie($this->session->getName(), $this->session->getId()));
        $this->client->request('POST', '/api/pages', [], [], ['ACCEPT' => 'application/json']);
    }

    /**
     * @When I go to the update :code page page
     */
    public function iGoToTheUpdatePagePage($code)
    {
        $page = $this->pageRepository->findOneByCode($code);
        Assert::notNull($page);
        $this->sharedStorage->set('page_code', $code);

        $this->updatePage->open(['id' => $page->getId()]);
    }

    /**
     * @When I fill the code with :code
     */
    public function iFillTheCodeWith($code)
    {
        $this->resolveCurrentPage()->fillCode($code);

        $this->sharedStorage->set('page_code', $code);
    }

    /**
     * @When I fill the name with :name
     */
    public function iFillTheNameWith($name)
    {
        $this->resolveCurrentPage()->fillName($name);
    }

    /**
     * @When I fill the link with :link
     */
    public function iFillTheLinkWith($link)
    {
        $this->resolveCurrentPage()->fillLink($link);
    }

    /**
     * @When I fill the slug with :slug
     */
    public function iFillTheSlugWith($slug)
    {
        $this->resolveCurrentPage()->fillSlug($slug);
    }

    /**
     * @When I fill the meta keywords with :metaKeywords
     */
    public function iFillTheMetaKeywordsWith($metaKeywords)
    {
        $this->resolveCurrentPage()->fillMetaKeywords($metaKeywords);
    }

    /**
     * @When I fill the meta description with :metaDescription
     */
    public function iFillTheMetaDescriptionWith($metaDescription)
    {
        $this->resolveCurrentPage()->fillMetaDescription($metaDescription);
    }

    /**
     * @When I fill the content with :content
     */
    public function iFillTheContentWith($content)
    {
        $this->resolveCurrentPage()->fillContent($content);
    }

    /**
     * @When /^I fill "([^"]*)" with (\d+) (?:character|characters)$/
     */
    public function iFillWithCharacter($fields, $length)
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
    public function iAddIt()
    {
        $this->resolveCurrentPage()->create();
    }

    /**
     * @When I update it
     */
    public function iUpdateIt()
    {
        $this->resolveCurrentPage()->saveChanges();
    }

    /**
     * @When I remove last page
     */
    public function iRemoveLastPage()
    {
        $code = $this->sharedStorage->get('page')->getCode();

        $this->indexPage->deleteResourceOnPage(['code' => $code]);
    }

    /**
     * @Then I should be notified that new page was created
     */
    public function iShouldBeNotifiedThatNewPageWasCreated()
    {
        $this->notificationChecker->checkNotification("Page has been successfully created.", NotificationType::success());
    }

    /**
     * @Then I should be notified that the page was updated
     */
    public function iShouldBeNotifiedThatThePageWasUpdated()
    {
        $this->notificationChecker->checkNotification("Page has been successfully updated.", NotificationType::success());
    }

    /**
     * @Then I should be notified that this page was removed
     */
    public function iShouldBeNotifiedThatThisPageWasRemoved()
    {
        $this->notificationChecker->checkNotification("Page has been successfully deleted.", NotificationType::success());
    }

    /**
     * @Then I should be notified that :fields fields can not be blank
     */
    public function iShouldBeNotifiedThatFieldsCanNotBeBlank($fields)
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
    public function iShouldBeNotifiedThatTheFieldsAreTooShort($fields)
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
    public function iShouldBeNotifiedThatFieldsAreTooLong($fields)
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
    public function thisPageShouldHaveCode($code)
    {
        Assert::eq($code, $this->getPage()->getCode());
    }

    /**
     * @Then it should have :name name
     */
    public function itShouldHaveName($name)
    {
        Assert::eq($this->getPage()->getName(), $name);
    }

    /**
     * @Then it should have :slug slug
     */
    public function itShouldHaveSlug($slug)
    {
        Assert::eq($this->getPage()->getSlug(), $slug);
    }

    /**
     * @Then it should have :metaKeywords meta keywords
     */
    public function itShouldHaveMetaKeywords($metaKeywords)
    {
        Assert::eq($metaKeywords, $this->getPage()->getMetaKeywords());
    }

    /**
     * @Then it should have :content content
     */
    public function itShouldHaveContent($content)
    {
        Assert::eq($content, $this->getPage()->getContent());
    }

    /**
     * @Then :number pages should exist in the store
     */
    public function pagesShouldExistInTheStore($number)
    {
        Assert::eq((int)$number, count($this->pageRepository->findAll()));
    }

    /**
     * @return CreatePageInterface|UpdatePageInterface|ContainsError|GenericPage|SymfonyPageInterface
     */
    private function resolveCurrentPage()
    {
        return $this->currentPageResolver->getCurrentPageWithForm([$this->createPage, $this->updatePage]);
    }

    /**
     * @return PageInterface
     */
    private function getPage()
    {
        $code = $this->sharedStorage->get('page_code');
        $page = $this->pageRepository->findOneByCode($code);
        $this->entityManager->refresh($page->getTranslation());
        Assert::notNull($page);

        return $page;
    }
}