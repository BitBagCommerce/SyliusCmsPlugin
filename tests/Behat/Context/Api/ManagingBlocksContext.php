<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\CmsPlugin\Behat\Context\Api;

use Behat\Behat\Context\Context;
use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Exception\TemplateTypeNotFound;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Page\SymfonyPageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\CmsPlugin\Behat\Behaviour\GenericBlock;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Block\CreatePageInterface;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Block\IndexPageInterface;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Block\UpdatePageInterface;
use Webmozart\Assert\Assert;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Zend\Stdlib\Request;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ManagingBlocksContext implements Context
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
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

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
     * @param BlockRepositoryInterface $blockRepository
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
        BlockRepositoryInterface $blockRepository,
        EntityManagerInterface $entityManager,
        Client $client,
        SessionInterface $session,
        Request $request
    )
    {
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->indexPage = $indexPage;
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->sharedStorage = $sharedStorage;
        $this->blockRepository = $blockRepository;
        $this->entityManager = $entityManager;
        $this->client = $client;
        $this->session = $session;
        $this->request = $request;
    }

    /**
     * @When I make a :request request to :address
     */
    public function iMakeARequestto($request, $address)
    {
        $this->client->getCookieJar()->set(new Cookie($this->session->getName(), $this->session->getId()));
        $this->client->request($request, $address, [], [], ['ACCEPT' => 'application/json']);
    }

    /**
     * @Then the response status code should be :code
     */
    public function responseStatusCodeShouldBe($code)
    {
        echo $this->getClientForAuthorization()->access_token;
    }

    private function getClientForAuthorization()
    {
        $re = $this->client->request("POST","/oauth/v2/token",array(
            "client_id" => 'demo_client',
            "client_secret" => 'secret_demo_client',
            "grant_type" => 'password',
            "username" => 'api@example.com',
            "password" => 'sylius-api'
        ));

        return $re;
    }

}
