<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Functional\Api;

use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use BitBag\SyliusCmsPlugin\Repository\CollectionRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\BitBag\SyliusCmsPlugin\Functional\FunctionalTestCase;

class SectionTest extends FunctionalTestCase
{
    public const CONTENT_TYPE_HEADER = ['CONTENT_TYPE' => 'application/ld+json', 'HTTP_ACCEPT' => 'application/ld+json'];

    public function setUp(): void
    {
        $this->loadFixturesFromFile('Api/SectionTest/collection.yml');
    }

    public function test_section_response(): void
    {
        /** @var CollectionInterface $section */
        $section = $this->getRepository()->findOneByCode('section1-code', 'en_US');
        $this->client->request('GET', '/api/v2/shop/cms-plugin/sections/' . $section->getId(), [], [], self::CONTENT_TYPE_HEADER);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Api/SectionTest/test_it_get_section_by_id', Response::HTTP_OK);
    }

    public function test_sections_response(): void
    {
        $this->client->request('GET', '/api/v2/shop/cms-plugin/sections', [], [], self::CONTENT_TYPE_HEADER);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Api/SectionTest/test_it_get_sections', Response::HTTP_OK);
    }

    private function getRepository(): CollectionRepositoryInterface
    {
        /** @var CollectionRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(CollectionInterface::class);

        return $repository;
    }
}
