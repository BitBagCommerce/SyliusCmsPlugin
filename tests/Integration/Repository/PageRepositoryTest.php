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
use BitBag\SyliusCmsPlugin\Entity\Block;
use BitBag\SyliusCmsPlugin\Entity\Media;
use BitBag\SyliusCmsPlugin\Entity\Page;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
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

        /** @var PageRepositoryInterface $pageRepository */
        $pageRepository = $this->getEntityManager()->getRepository(Page::class);

        $page1_2_array = $pageRepository->findEnabled(true);
        $page3_array = $pageRepository->findEnabled(false);

        self::assertCount(2, $page1_2_array);
        self::assertCount(1, $page3_array);
    }

    public function test_it_finds_enabled_page_by_code(): void
    {
        $this->loadFixturesFromFile('PageRepositoryTest/test_it_finds_page_by_code.yml');

        /** @var PageRepositoryInterface $pageRepository */
        $pageRepository = $this->getEntityManager()->getRepository(Page::class);

        $page1 = $pageRepository->findOneEnabledByCode('page1-code', 'en_US');
        $page3 = $pageRepository->findOneEnabledByCode('page3-code', 'en_US');

        self::assertNotNull($page1);
        self::assertNull($page3);
    }

    public function test_it_finds_enabled_page_by_section_code(): void
    {
        $this->loadFixturesFromFile('PageRepositoryTest/test_it_finds_page_by_section_code.yml');

        /** @var PageRepositoryInterface $pageRepository */
        $pageRepository = $this->getEntityManager()->getRepository(Page::class);

        $page1_array = $pageRepository->findBySectionCode('section1-code', 'en_US');
        $page3_array = $pageRepository->findBySectionCode('section3-code', 'en_US');

        self::assertNotEmpty($page1_array);
        self::assertEmpty($page3_array);
    }

    public function test_it_finds_enabled_page_by_product(): void
    {
        $this->loadFixturesFromFile('PageRepositoryTest/test_it_finds_page_by_product.yml');

        /** @var PageRepositoryInterface $pageRepository */
        $pageRepository = $this->getEntityManager()->getRepository(Page::class);

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

        /** @var PageRepositoryInterface $pageRepository */
        $pageRepository = $this->getEntityManager()->getRepository(Page::class);

        /** @var ProductRepositoryInterface $productRepository */
        $productRepository = $this->getEntityManager()->getRepository(Product::class);

        /** @var Product $product1 */
        $product1 = $productRepository->findOneByCode('MUG_SW');
        /** @var Product $product3 */
        $product3 = $productRepository->findOneByCode('MUG_SW3');

        $page1_array = $pageRepository->findByProductAndSectionCode($product1, 'section1-code','code', null);
        $page3_array = $pageRepository->findByProductAndSectionCode($product3, 'section3-code','code', null);

        self::assertNotEmpty($page1_array);
        self::assertEmpty($page3_array);
    }
}
