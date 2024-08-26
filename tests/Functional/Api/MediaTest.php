<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Functional\Api;

use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\Sylius\CmsPlugin\Functional\FunctionalTestCase;

class MediaTest extends FunctionalTestCase
{
    public const CONTENT_TYPE_HEADER = ['CONTENT_TYPE' => 'application/ld+json', 'HTTP_ACCEPT' => 'application/ld+json'];

    public function setUp(): void
    {
        $this->loadFixturesFromFile('Api/MediaTest/media.yml');
    }

    public function test_media_response(): void
    {
        /** @var MediaInterface $media */
        $media = $this->getRepository()->findOneEnabledByCode('media1-code', 'en_US', 'code');

        $this->client->request('GET', '/api/v2/shop/cms-plugin/media/' . $media->getId(), [], [], self::CONTENT_TYPE_HEADER);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Api/MediaTest/test_it_get_media_by_id', Response::HTTP_OK);
    }

    public function test_medias_response(): void
    {
        $this->client->request('GET', '/api/v2/shop/cms-plugin/media', [], [], self::CONTENT_TYPE_HEADER);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Api/MediaTest/test_it_get_media', Response::HTTP_OK);
    }

    private function getRepository(): MediaRepositoryInterface
    {
        /** @var MediaRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(MediaInterface::class);

        return $repository;
    }
}
