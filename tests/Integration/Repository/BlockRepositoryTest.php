<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Integration\Repository;

use ApiTestCase\JsonApiTestCase;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Repository\BlockRepositoryInterface;

class BlockRepositoryTest extends JsonApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_finds_enabled_block_by_code(): void
    {
        $this->loadFixturesFromFile('BlockRepositoryTest/test_it_finds_block_by_code.yml');

        $blockRepository = $this->getRepository();

        $block1 = $blockRepository->findEnabledByCode('block1-code', 'code');
        $block3 = $blockRepository->findEnabledByCode('block3-code', 'code');

        self::assertNotNull($block1);
        self::assertNull($block3);
    }

    public function test_it_finds_enabled_block_by_collection_code(): void
    {
        $this->loadFixturesFromFile('BlockRepositoryTest/test_it_finds_block_by_collection_code.yml');

        $blockRepository = $this->getRepository();

        $block_array1 = $blockRepository->findByCollectionCode('collection1-code', 'code');
        $block_array3 = $blockRepository->findByCollectionCode('collection3-code', 'code');

        self::assertNotEmpty($block_array1);
        self::assertEmpty($block_array3);
    }

    private function getRepository(): BlockRepositoryInterface
    {
        /** @var BlockRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(BlockInterface::class);

        return $repository;
    }
}
