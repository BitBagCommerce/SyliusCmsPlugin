<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Integration\Repository;

use ApiTestCase\JsonApiTestCase;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;

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

    public function test_it_finds_enabled_page_by_section_code(): void
    {
        $this->loadFixturesFromFile('PageRepositoryTest/test_it_finds_page_by_section_code.yml');

        $pageRepository = $this->getRepository();

        $page1_array = $pageRepository->findByCollectionCode('section1-code', 'en_US');
        $page3_array = $pageRepository->findByCollectionCode('section3-code', 'en_US');

        self::assertNotEmpty($page1_array);
        self::assertEmpty($page3_array);
    }

    public function test_it_finds_enabled_page_by_product(): void
    {
        $this->loadFixturesFromFile('PageRepositoryTest/test_it_finds_page_by_product.yml');

        $pageRepository = $this->getRepository();

        /** @var ProductRepositoryInterface $productRepository */
        $productRepository = $this->getEntityManager()->getRepository(Product::class);

        /** @var Product $product1 */
        $product1 = $productRepository->findOneByCode('MUG_SW');
        /** @var Product $product3 */
        $product3 = $productRepository->findOneByCode('MUG_SW3');

        $page1_array = $pageRepository->findByProduct($product1, 'code', null);
        $page3_array = $pageRepository->findByProduct($product3, 'code', null);

        self::assertNotEmpty($page1_array);
        self::assertEmpty($page3_array);
    }

    public function test_it_finds_enabled_page_by_product_and_section_code(): void
    {
        $this->loadFixturesFromFile('PageRepositoryTest/test_it_finds_page_by_product_and_section_code.yml');

        $pageRepository = $this->getRepository();

        /** @var ProductRepositoryInterface $productRepository */
        $productRepository = $this->getEntityManager()->getRepository(Product::class);

        /** @var Product $product1 */
        $product1 = $productRepository->findOneByCode('MUG_SW');
        /** @var Product $product3 */
        $product3 = $productRepository->findOneByCode('MUG_SW3');

        $page1_array = $pageRepository->findByProductAndCollectionCode($product1, 'section1-code', 'code', null);
        $page3_array = $pageRepository->findByProductAndCollectionCode($product3, 'section3-code', 'code', null);

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
