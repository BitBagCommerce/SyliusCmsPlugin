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
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Behat\Service\SharedStorageInterface;
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
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param RandomStringGeneratorInterface $randomStringGenerator
     * @param FactoryInterface $pageFactory
     * @param PageRepositoryInterface $pageRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        RandomStringGeneratorInterface $randomStringGenerator,
        FactoryInterface $pageFactory,
        PageRepositoryInterface $pageRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->sharedStorage = $sharedStorage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->pageFactory = $pageFactory;
        $this->pageRepository = $pageRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Given there are :number pages
     */
    public function thereArePages(int $number)
    {
        for ($i = 0; $i < $number; $i++) {
            $this->createPage();
        }
    }

    /**
     * @Given there is a cms page with :name name
     */
    public function thereIsACmsPageWithName(string $name): void
    {
        $page = $this->createPage();

        $page->setName($name);
        $page->setCode(strtolower(str_replace(' ', '_', $name)));

        $this->entityManager->flush();
    }

    /**
     * @Given it has :metaKeywords meta keywords
     */
    public function itHasMetaKeywords(string $metaKeywords): void
    {
        $page = $this->createPage();

        $page->setMetaKeywords($metaKeywords);

        $this->entityManager->flush();
    }

    /**
     * @Given it has :metaDescription meta description
     */
    public function itHasMetaDescription(string $metaDescription): void
    {
        $page = $this->createPage();
        
        $page->setMetaDescription($metaDescription);

        $this->entityManager->flush();
    }

    /**
     * @Given it has :content content
     */
    public function itHasContent(string $content)
    {
        $page = $this->createPage();
        
        $page->setMetaKeywords($content);

        $this->entityManager->flush();
    }

    /**
     * @return PageInterface
     */
    private function createPage(): PageInterface
    {
        /** @var PageInterface $page */
        $page = $this->pageFactory->createNew();
        $channel = $this->sharedStorage->get('channel');

        $page->setCode($this->randomStringGenerator->generate());
        $page->setCurrentLocale($channel->getLocales()->first()->getCode());
        $page->setName($this->randomStringGenerator->generate());
        $page->setSlug($this->randomStringGenerator->generate());
        $page->setContent($this->randomStringGenerator->generate());

        $this->pageRepository->add($page);
        $this->sharedStorage->set('page', $page);
        
        return $page;
    }
}
