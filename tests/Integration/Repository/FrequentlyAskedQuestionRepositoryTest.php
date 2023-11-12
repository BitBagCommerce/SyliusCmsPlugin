<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Integration\Repository;

use ApiTestCase\JsonApiTestCase;
use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use BitBag\SyliusCmsPlugin\Repository\FrequentlyAskedQuestionRepositoryInterface;

class FrequentlyAskedQuestionRepositoryTest extends JsonApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_finds_enabled_frequently_asked_questions_ordered_by_position(): void
    {
        $this->loadFixturesFromFile('FrequentlyAskedQuestionRepositoryTest//test_it_finds_faq_by_position.yml');

        $localeCode = 'en_US';
        $channelCode = 'code';

        $faqRepository = $this->getRepository();

        $faqs = $faqRepository->findEnabledOrderedByPosition($localeCode, $channelCode);

        self::assertNotEmpty($faqs);
        self::assertCount(2, $faqs);

        $previousPosition = null;
        foreach ($faqs as $faq) {
            if (null !== $previousPosition) {
                self::assertGreaterThanOrEqual($previousPosition, $faq->getPosition());
                self::assertTrue($faq->isEnabled());
            }
            $previousPosition = $faq->getPosition();
        }
    }

    public function test_it_finds_enabled_frequently_asked_question_by_code(): void
    {
        $this->loadFixturesFromFile('FrequentlyAskedQuestionRepositoryTest/test_it_finds_faq_by_code.yml');

        $faq1Code = 'faq1-code';
        $faq3Code = 'faq3-code';

        $faqRepository = $this->getRepository();

        $faq1 = $faqRepository->findOneEnabledByCode($faq1Code);
        $faq3 = $faqRepository->findOneEnabledByCode($faq3Code);

        self::assertNotNull($faq1);
        self::assertEquals($faq1Code, $faq1->getCode());
        self::assertTrue($faq1->isEnabled());
        self::assertNull($faq3);
    }

    private function getRepository(): FrequentlyAskedQuestionRepositoryInterface
    {
        /** @var FrequentlyAskedQuestionRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(FrequentlyAskedQuestionInterface::class);

        return $repository;
    }
}
