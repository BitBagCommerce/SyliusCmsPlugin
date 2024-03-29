<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Functional\Api;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\BitBag\SyliusCmsPlugin\Functional\FunctionalTestCase;

class PageTest extends FunctionalTestCase
{
    public const CONTENT_TYPE_HEADER = ['CONTENT_TYPE' => 'application/ld+json', 'HTTP_ACCEPT' => 'application/ld+json'];

    public function setUp(): void
    {
        $this->loadFixturesFromFile('Api/PageTest/page.yml');
    }

    public function test_page_response(): void
    {
        /** @var PageInterface $page */
        $page = $this->getRepository()->findOneEnabledByCode('page1-code', 'en_US');
        $this->client->request('GET', '/api/v2/shop/cms-plugin/pages/' . $page->getId(), [], [], self::CONTENT_TYPE_HEADER);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Api/PageTest/test_it_get_page_by_id', Response::HTTP_OK);
    }

    public function test_pages_response(): void
    {
        $this->client->request('GET', '/api/v2/shop/cms-plugin/pages', [], [], self::CONTENT_TYPE_HEADER);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Api/PageTest/test_it_get_pages', Response::HTTP_OK);
    }

    private function getRepository(): PageRepositoryInterface
    {
        /** @var PageRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(PageInterface::class);

        return $repository;
    }
}
