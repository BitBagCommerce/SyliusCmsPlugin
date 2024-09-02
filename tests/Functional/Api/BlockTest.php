<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Functional\Api;

use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Repository\BlockRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\Sylius\CmsPlugin\Functional\FunctionalTestCase;

class BlockTest extends FunctionalTestCase
{
    public const CONTENT_TYPE_HEADER = ['CONTENT_TYPE' => 'application/ld+json', 'HTTP_ACCEPT' => 'application/ld+json'];

    public function setUp(): void
    {
        $this->loadFixturesFromFile('Api/BlockTest/block.yml');
    }

    public function test_block_response(): void
    {
        /** @var BlockInterface $block */
        $block = $this->getRepository()->findEnabledByCode('block1-code', 'code');
        $this->client->request('GET', '/api/v2/shop/cms-plugin/blocks/' . $block->getId(), [], [], self::CONTENT_TYPE_HEADER);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Api/BlockTest/test_it_get_block_by_id', Response::HTTP_OK);
    }

    public function test_blocks_response(): void
    {
        $this->client->request('GET', '/api/v2/shop/cms-plugin/blocks', [], [], self::CONTENT_TYPE_HEADER);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Api/BlockTest/test_it_get_blocks', Response::HTTP_OK);
    }

    private function getRepository(): BlockRepositoryInterface
    {
        /** @var BlockRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(BlockInterface::class);

        return $repository;
    }
}
