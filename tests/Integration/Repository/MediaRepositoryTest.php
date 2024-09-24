<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Integration\Repository;

use ApiTestCase\JsonApiTestCase;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;

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

        $media1 = $mediaRepository->findOneEnabledByCode('media1-code', 'code');
        $media3 = $mediaRepository->findOneEnabledByCode('media3-code', 'code');

        self::assertNotNull($media1);
        self::assertNull($media3);
    }

    public function test_it_finds_media_by_name_part(): void
    {
        $this->loadFixturesFromFile('MediaRepositoryTest/test_it_finds_media_by_name.yml');

        $repository = $this->getRepository();

        $phrase = 'media';
        $types = [
            MediaInterface::IMAGE_TYPE,
            MediaInterface::FILE_TYPE,
            MediaInterface::VIDEO_TYPE,
        ];
        $media = $repository->findByNamePart($phrase, $types);

        self::assertIsArray($media);
        self::assertCount(3, $media);
    }

    private function getRepository(): MediaRepositoryInterface
    {
        /** @var MediaRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(MediaInterface::class);

        return $repository;
    }
}
