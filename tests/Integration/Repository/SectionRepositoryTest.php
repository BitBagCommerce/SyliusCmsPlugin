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
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Doctrine\ORM\QueryBuilder;

class SectionRepositoryTest extends JsonApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_creates_list_query_builder(): void
    {
        $repository = $this->getRepository();

        $localeCode = 'en_US';
        $queryBuilder = $repository->createListQueryBuilder($localeCode);

        self::assertInstanceOf(QueryBuilder::class, $queryBuilder);
        self::assertNotNull($queryBuilder->getQuery());
    }

    public function test_it_finds_section_by_name_part(): void
    {
        $this->loadFixturesFromFile('SectionRepositoryTest/test_it_finds_section_by_name.yml');

        $repository = $this->getRepository();

        $phrase = 'translation';
        $locale = 'en_US';
        $sections = $repository->findByNamePart($phrase, $locale);

        self::assertIsArray($sections);
        self::assertCount(3, $sections);
    }

    public function test_it_finds_one_by_code(): void
    {
        $this->loadFixturesFromFile('SectionRepositoryTest/test_it_finds_section_by_code.yml');

        $repository = $this->getRepository();

        $code = 'section1-code';
        $localeCode = 'en_US';
        $section = $repository->findOneByCode($code, $localeCode);

        self::assertInstanceOf(SectionInterface::class, $section);
    }

    public function test_it_finds_by_codes_and_locale(): void
    {
        $this->loadFixturesFromFile('SectionRepositoryTest/test_it_finds_section_by_codes_and_locale.yml');

        $repository = $this->getRepository();

        $codes = 'section1-code,section2-code';
        $localeCode = 'en_US';
        $sections = $repository->findByCodesAndLocale($codes, $localeCode);

        self::assertIsArray($sections);
        self::assertCount(2, $sections);
    }

    private function getRepository(): SectionRepositoryInterface
    {
        /** @var SectionRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(SectionInterface::class);

        return $repository;
    }
}
