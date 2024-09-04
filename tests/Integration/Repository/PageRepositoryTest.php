<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Integration\Repository;

use ApiTestCase\JsonApiTestCase;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Repository\PageRepositoryInterface;

class PageRepositoryTest extends JsonApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_finds_enabled_pages(): void
    {
        $this->loadFixturesFromFile('PageRepositoryTest/test_it_finds_page_by_code.yml');

        $pageRepository = $this->getRepository();

        $page1_2_array = $pageRepository->findEnabled(true);
        $page3_array = $pageRepository->findEnabled(false);

        self::assertCount(2, $page1_2_array);
        self::assertCount(1, $page3_array);
    }

    public function test_it_finds_enabled_page_by_code(): void
    {
        $this->loadFixturesFromFile('PageRepositoryTest/test_it_finds_page_by_code.yml');

        $pageRepository = $this->getRepository();

        $page1 = $pageRepository->findOneEnabledByCode('page1-code', 'en_US');
        $page3 = $pageRepository->findOneEnabledByCode('page3-code', 'en_US');

        self::assertNotNull($page1);
        self::assertNull($page3);
    }

    public function test_it_finds_enabled_page_by_collection_code(): void
    {
        $this->loadFixturesFromFile('PageRepositoryTest/test_it_finds_page_by_collection_code.yml');

        $pageRepository = $this->getRepository();

        $page1_array = $pageRepository->findByCollectionCode('collection1-code');
        $page3_array = $pageRepository->findByCollectionCode('collection3-code');

        self::assertNotEmpty($page1_array);
        self::assertEmpty($page3_array);
    }

    private function getRepository(): PageRepositoryInterface
    {
        /** @var PageRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(PageInterface::class);

        return $repository;
    }
}
