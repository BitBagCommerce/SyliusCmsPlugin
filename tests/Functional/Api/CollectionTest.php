<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Functional\Api;

use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Repository\CollectionRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\Sylius\CmsPlugin\Functional\FunctionalTestCase;

class CollectionTest extends FunctionalTestCase
{
    public const CONTENT_TYPE_HEADER = ['CONTENT_TYPE' => 'application/ld+json', 'HTTP_ACCEPT' => 'application/ld+json'];

    public function setUp(): void
    {
        $this->loadFixturesFromFile('Api/CollectionTest/collection.yml');
    }

    public function test_collection_response(): void
    {
        /** @var CollectionInterface $collection */
        $collection = $this->getRepository()->findOneByCode('collection1-code');
        $this->client->request('GET', '/api/v2/shop/cms-plugin/collections/' . $collection->getId(), [], [], self::CONTENT_TYPE_HEADER);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Api/CollectionTest/test_it_get_collection_by_id', Response::HTTP_OK);
    }

    public function test_collections_response(): void
    {
        $this->client->request('GET', '/api/v2/shop/cms-plugin/collections', [], [], self::CONTENT_TYPE_HEADER);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Api/CollectionTest/test_it_get_collections', Response::HTTP_OK);
    }

    private function getRepository(): CollectionRepositoryInterface
    {
        /** @var CollectionRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(CollectionInterface::class);

        return $repository;
    }
}
