<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Functional\Api;

use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use BitBag\SyliusCmsPlugin\Repository\FrequentlyAskedQuestionRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\BitBag\SyliusCmsPlugin\Functional\FunctionalTestCase;

class FrequentlyAskedQuestionTest extends FunctionalTestCase
{
    public const CONTENT_TYPE_HEADER = ['CONTENT_TYPE' => 'application/ld+json', 'HTTP_ACCEPT' => 'application/ld+json'];

    public function setUp(): void
    {
        $this->loadFixturesFromFile('Api/FrequentlyAskedQuestionTest/frequently_asked_question.yml');
    }

    public function test_block_response(): void
    {
        /** @var FrequentlyAskedQuestionInterface $faq */
        $faq = $this->getRepository()->findOneEnabledByCode('faq1-code');
        $this->client->request('GET', '/api/v2/shop/cms-plugin/faq/' . $faq->getId(), [], [], self::CONTENT_TYPE_HEADER);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Api/FrequentlyAskedQuestionTest/test_it_get_frequently_asked_question_by_id', Response::HTTP_OK);
    }

//    public function test_blocks_response(): void{
//        $this->client->request('GET', '/api/v2/shop/cms-plugin/faq', [], [], self::CONTENT_TYPE_HEADER);
//        $response = $this->client->getResponse();
//
//        $this->assertResponse($response, 'Api/BlockTest/test_it_get_blocks', Response::HTTP_OK);
//    }

    private function getRepository(): FrequentlyAskedQuestionRepositoryInterface
    {
        /** @var FrequentlyAskedQuestionRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(FrequentlyAskedQuestionInterface::class);

        return $repository;
    }
}
