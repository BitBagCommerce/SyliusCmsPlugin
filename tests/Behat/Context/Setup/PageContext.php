<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\RandomStringGeneratorInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class PageContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var RandomStringGeneratorInterface
     */
    private $randomStringGenerator;

    /**
     * @var FactoryInterface
     */
    private $pageFactory;

    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var SectionRepositoryInterface
     */
    private $sectionRepository;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param RandomStringGeneratorInterface $randomStringGenerator
     * @param FactoryInterface $pageFactory
     * @param PageRepositoryInterface $pageRepository
     * @param EntityManagerInterface $entityManager
     * @param ProductRepositoryInterface $productRepository
     * @param SectionRepositoryInterface $sectionRepository
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        RandomStringGeneratorInterface $randomStringGenerator,
        FactoryInterface $pageFactory,
        PageRepositoryInterface $pageRepository,
        EntityManagerInterface $entityManager,
        ProductRepositoryInterface $productRepository,
        SectionRepositoryInterface $sectionRepository
    )
    {
        $this->sharedStorage = $sharedStorage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->pageFactory = $pageFactory;
        $this->pageRepository = $pageRepository;
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * @Given there is a page in the store
     */
    public function thereIsAPageInTheStore(): void
    {
        $page = $this->createPage();

        $this->savePage($page);
    }

    /**
     * @Given there is an existing page with :name name
     */
    public function thereIsAPageWithName(string $name): void
    {
        $page = $this->createPage(strtolower(StringInflector::nameToCode($name)), $name);

        $this->savePage($page);
    }

    /**
     * @Given there are :number pages in the store
     */
    public function thereArePagesInTheStore(int $number): void
    {
        for ($i = 0; $i < $number; $i++) {
            $page = $this->createPage();

            $this->savePage($page);
        }
    }

    /**
     * @Given there is an existing page with :code code
     */
    public function thereIsAnExistingPageWithCode(string $code): void
    {
        $page = $this->createPage($code);

        $this->savePage($page);
    }

    /**
     * @Given this page has :code code
     */
    public function thisPageHasCode(string $code): void
    {
        $this->sharedStorage->get('page')->setCode($code);

        $this->entityManager->flush();
    }

    /**
     * @Given this page has :name name
     */
    public function thisPageHasName(string $name): void
    {
        $this->sharedStorage->get('page')->setName($name);

        $this->entityManager->flush();
    }

    /**
     * @Given this page also has :slug slug
     */
    public function thisPageAlsoHasSlug(string $slug): void
    {
        $this->sharedStorage->get('page')->setSlug($slug);

        $this->entityManager->flush();
    }

    /**
     * @Given this page also has :content content
     */
    public function thisPageAlsoHasContent(string $content): void
    {
        $this->sharedStorage->get('page')->setContent($content);

        $this->entityManager->flush();
    }

    /**
     * @Given this page has these products associated with it
     */
    public function thisPageHasTheseProductsAssociatedWithIt(): void
    {
        $products = $this->productRepository->findAll();

        foreach ($products as $product) {
            $this->sharedStorage->get('page')->addProduct($product);
        }

        $this->entityManager->flush();
    }

    /**
     * @Given this page has these sections associated with it
     */
    public function thisPageHasTheseSectionsAssociatedWithIt(): void
    {
        $sections = $this->sectionRepository->findAll();

        foreach ($sections as $section) {
            $this->sharedStorage->get('page')->addSection($section);
        }

        $this->entityManager->flush();
    }

    /**
     * @Given these pages have this section associated with it
     */
    public function thesePagesHaveThisSectionAssociatedWithIt(): void
    {
        $section = $this->sharedStorage->get('section');
        $pages = $this->pageRepository->findAll();

        /** @var PageInterface $page */
        foreach ($pages as $page) {
            $page->addSection($section);
        }

        $this->entityManager->flush();
    }

    /**
     * @param null|string $code
     * @param null|string $name
     * @param null|string $content
     *
     * @return PageInterface
     */
    private function createPage(?string $code = null, ?string $name = null, ?string $content = null): PageInterface
    {
        /** @var PageInterface $page */
        $page = $this->pageFactory->createNew();

        if (null === $code) {
            $code = $this->randomStringGenerator->generate();
        }

        if (null === $name) {
            $name = $this->randomStringGenerator->generate();
        }

        if (null === $content) {
            $content = $this->randomStringGenerator->generate();
        }

        $page->setCode($code);
        $page->setCurrentLocale('en_US');
        $page->setName($name);
        $page->setSlug($this->randomStringGenerator->generate());
        $page->setContent($content);

        return $page;
    }

    /**
     * @param PageInterface $page
     */
    private function savePage(PageInterface $page): void
    {
        $this->pageRepository->add($page);
        $this->sharedStorage->set('page', $page);
    }
}

