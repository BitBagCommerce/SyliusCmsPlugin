<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\CmsPlugin\Entity\ContentConfiguration;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Entity\Media;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\MediaProvider\ProviderInterface;
use Sylius\CmsPlugin\Repository\CollectionRepositoryInterface;
use Sylius\CmsPlugin\Repository\PageRepositoryInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tests\Sylius\CmsPlugin\Behat\Helpers\ContentElementHelper;
use Tests\Sylius\CmsPlugin\Behat\Service\RandomStringGeneratorInterface;

final class PageContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private RandomStringGeneratorInterface $randomStringGenerator,
        private FactoryInterface $pageFactory,
        private PageRepositoryInterface $pageRepository,
        private EntityManagerInterface $entityManager,
        private ProductRepositoryInterface $productRepository,
        private CollectionRepositoryInterface $collectionRepository,
        private ProviderInterface $imageProvider,
    ) {
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
     * @Given there is a page in the store with :contentElement content element
     */
    public function thereIsAPageInTheStoreWithTextareaContentElement(string $contentElement): void
    {
        $page = $this->createPageWithContentElement($contentElement);

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
     * @Given this page has these collections associated with it
     */
    public function thisPageHasTheseCollectionsAssociatedWithIt(): void
    {
        $collections = $this->collectionRepository->findAll();

        foreach ($collections as $collection) {
            $this->sharedStorage->get('page')->addCollection($collection);
        }

        $this->entityManager->flush();
    }

    /**
     * @Given these pages have this collection associated with it
     */
    public function thesePagesHaveThisCollectionAssociatedWithIt(): void
    {
        $collection = $this->sharedStorage->get('collection');
        $pages = $this->pageRepository->findAll();

        /** @var PageInterface $page */
        foreach ($pages as $page) {
            $page->addCollection($collection);
        }

        $this->entityManager->flush();
    }

    private function createPage(
        ?string $code = null,
        ?string $name = null,
        ChannelInterface $channel = null,
    ): PageInterface {
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

        $page->setCode($code);
        $page->setCurrentLocale('en_US');
        $page->setName($name);
        $page->setSlug($this->randomStringGenerator->generate());
        $page->addChannel($channel);

        return $page;
    }

    private function createPageWithContentElement(string $contentElement): PageInterface
    {
        $page = $this->createPage();

        /** @var ContentConfigurationInterface $contentConfiguration */
        $contentConfiguration = new ContentConfiguration();
        $contentConfiguration->setType(mb_strtolower($contentElement));
        $contentConfiguration->setLocale('en_US');
        $contentConfiguration->setConfiguration(ContentElementHelper::getExampleConfigurationByContentElement($contentElement));
        $contentConfiguration->setPage($page);

        $page->addContentElement($contentConfiguration);

        return $page;
    }

    private function uploadImage(string $name): MediaInterface
    {
        $image = new Media();
        $image->setCode('test');
        $image->setType('image');

        $uploadedImage = new UploadedFile(__DIR__ . '/../../Resources/images/' . $name, $name);

        $image->setFile($uploadedImage);

        $this->imageProvider->upload($image);

        return $image;
    }

    private function savePage(PageInterface $page): void
    {
        $this->pageRepository->add($page);
        $this->sharedStorage->set('page', $page);
    }
}
