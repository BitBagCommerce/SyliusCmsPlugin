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
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;

class MediaRepositoryTest extends JsonApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_finds_enabled_media_by_code(): void
    {
        $this->loadFixturesFromFile('MediaRepositoryTest/test_it_finds_media_by_code.yml');

        $mediaRepository = $this->getRepository();

        $media1 = $mediaRepository->findOneEnabledByCode('media1-code', 'en_US', 'code');
        $media3 = $mediaRepository->findOneEnabledByCode('media3-code', 'en_US', 'code');

        self::assertNotNull($media1);
        self::assertNull($media3);
    }

    public function test_it_finds_enabled_media_by_section_code(): void
    {
        $this->loadFixturesFromFile('MediaRepositoryTest/test_it_finds_media_by_section_code.yml');

        $mediaRepository = $this->getRepository();

        $media1 = $mediaRepository->findByCollectionCode('section1-code', 'en_US', 'code');
        $media3 = $mediaRepository->findByCollectionCode('section3-code', 'en_US', 'code');

        self::assertNotEmpty($media1);
        self::assertEmpty($media3);
    }

    public function test_it_finds_enabled_media_by_product_code(): void
    {
        $this->loadFixturesFromFile('MediaRepositoryTest/test_it_finds_media_by_product_code.yml');

        $mediaRepository = $this->getRepository();

        $media1_array = $mediaRepository->findByProductCode('MUG_SW', 'en_US', 'code');
        $media3_array = $mediaRepository->findByProductCode('MUG_SW3', 'en_US', 'code');

        self::assertNotEmpty($media1_array);
        self::assertEmpty($media3_array);
    }

    private function getRepository(): MediaRepositoryInterface
    {
        /** @var MediaRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(MediaInterface::class);

        return $repository;
    }
}
