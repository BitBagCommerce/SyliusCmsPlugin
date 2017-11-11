<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\CmsPlugin\Entity\PageInterface;
use BitBag\CmsPlugin\Repository\PageRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\BitBag\CmsPlugin\Behat\Service\RandomStringGeneratorInterface;

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
     * @param SharedStorageInterface $sharedStorage
     * @param RandomStringGeneratorInterface $randomStringGenerator
     * @param FactoryInterface $pageFactory
     * @param PageRepositoryInterface $pageRepository
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        RandomStringGeneratorInterface $randomStringGenerator,
        FactoryInterface $pageFactory,
        PageRepositoryInterface $pageRepository
    )
    {
        $this->sharedStorage = $sharedStorage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->pageFactory = $pageFactory;
        $this->pageRepository = $pageRepository;
    }

    /**
     * @Given there is a page in the store
     */
    public function thereIsAPageInTheStore(): void
    {
        $page = $this->createPage();

        $this->pageRepository->add($page);
    }

    /**
     * @Given there is an existing page with :name name
     */
    public function thereIsACmsPageWithName(string $name): void
    {
        $page = $this->createPage();

        $page->setName($name);
        $page->setCode(strtolower(StringInflector::nameToCode($name)));

        $this->pageRepository->add($page);
    }

    /**
     * @Given there is an existing page with :code code
     */
    public function thereIsAnExistingPageWithCode(string $code): void
    {
        $page = $this->createPage();

        $page->setCode($code);

        $this->pageRepository->add($page);
    }

    /**
     * @Given it has :metaKeywords meta keywords
     */
    public function itHasMetaKeywords(string $metaKeywords): void
    {
        $page = $this->createPage();

        $page->setMetaKeywords($metaKeywords);

        $this->pageRepository->add($page);
    }

    /**
     * @Given it has :metaDescription meta description
     */
    public function itHasMetaDescription(string $metaDescription): void
    {
        $page = $this->createPage();

        $page->setMetaDescription($metaDescription);

        $this->pageRepository->add($page);
    }

    /**
     * @Given it has :content content
     */
    public function itHasContent(string $content)
    {
        $page = $this->createPage();

        $page->setMetaKeywords($content);

        $this->pageRepository->add($page);
    }

    /**
     * @return PageInterface
     */
    private function createPage(): PageInterface
    {
        /** @var PageInterface $page */
        $page = $this->pageFactory->createNew();

        $page->setCode($this->randomStringGenerator->generate());
        $page->setCurrentLocale('en_US');
        $page->setName($this->randomStringGenerator->generate());
        $page->setSlug($this->randomStringGenerator->generate());
        $page->setContent($this->randomStringGenerator->generate());

        $this->sharedStorage->set('page', $page);

        return $page;
    }
}
