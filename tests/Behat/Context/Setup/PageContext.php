<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\Media;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Entity\PageImage;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use BitBag\SyliusCmsPlugin\Uploader\MediaUploaderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\RandomStringGeneratorInterface;

final class PageContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var RandomStringGeneratorInterface */
    private $randomStringGenerator;

    /** @var FactoryInterface */
    private $pageFactory;

    /** @var PageRepositoryInterface */
    private $pageRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var SectionRepositoryInterface */
    private $sectionRepository;

    /** @var MediaUploaderInterface */
    private $mediaUploader;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        RandomStringGeneratorInterface $randomStringGenerator,
        FactoryInterface $pageFactory,
        PageRepositoryInterface $pageRepository,
        EntityManagerInterface $entityManager,
        ProductRepositoryInterface $productRepository,
        SectionRepositoryInterface $sectionRepository,
        MediaUploaderInterface $mediaUploader

    ) {
        $this->sharedStorage = $sharedStorage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->pageFactory = $pageFactory;
        $this->pageRepository = $pageRepository;
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
        $this->sectionRepository = $sectionRepository;
        $this->mediaUploader = $mediaUploader;
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
        for ($i = 0; $i < $number; ++$i) {
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
     * @Given this page also has :title title
     */
    public function thisPageAlsoHasTitle(string $title): void
    {
        $this->sharedStorage->get('page')->setTitle($title);

        $this->entityManager->flush();
    }

    /**
     * @Given this page also has :content image
     */
    public function thisPageAlsoHasImage(string $image): void
    {
        $image = $this->uploadImage($image);

        $this->sharedStorage->get('page')->setImage($image);

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

    private function createPage(?string $code = null, ?string $name = null, ?string $content = null, ChannelInterface $channel = null): PageInterface
    {
        /** @var PageInterface $page */
        $page = $this->pageFactory->createNew();

        if (null === $channel && $this->sharedStorage->has('channel')) {
            $channel = $this->sharedStorage->get('channel');
        }

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
        $page->addChannel($channel);

        return $page;
    }

    private function uploadImage(string $name): MediaInterface
    {
        $image = new Media();
        $image->setCode('test');
        $image->setType('image');

        $uploadedImage = new UploadedFile(__DIR__ . '/../../Resources/images/' . $name, $name);

        $image->setFile($uploadedImage);

        $this->mediaUploader->upload($image,'/tests/Application/Resources/images/' );

        return $image;
    }

    private function savePage(PageInterface $page): void
    {
        $this->pageRepository->add($page);
        $this->sharedStorage->set('page', $page);
    }
}
