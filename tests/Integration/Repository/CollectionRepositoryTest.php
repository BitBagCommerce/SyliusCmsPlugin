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
use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use BitBag\SyliusCmsPlugin\Repository\CollectionRepositoryInterface;

final class CollectionRepositoryTest extends JsonApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_finds_collection_by_name_part(): void
    {
        $this->loadFixturesFromFile('CollectionRepositoryTest/test_it_finds_collection_by_name.yml');

        $repository = $this->getRepository();

        $phrase = 'collection';
        $collections = $repository->findByNamePart($phrase);

        self::assertIsArray($collections);
        self::assertCount(3, $collections);
    }

    public function test_it_finds_collection_by_name_part_and_type(): void
    {
        $this->loadFixturesFromFile('CollectionRepositoryTest/test_it_finds_collection_by_name.yml');

        $repository = $this->getRepository();

        $phrase = 'collection';
        $type = 'page';
        $collections = $repository->findByNamePartAndType($phrase, $type);

        self::assertIsArray($collections);
        self::assertCount(1, $collections);
    }

    public function test_it_finds_one_by_code(): void
    {
        $this->loadFixturesFromFile('CollectionRepositoryTest/test_it_finds_collection_by_code.yml');

        $repository = $this->getRepository();

        $code = 'collection1-code';
        $localeCode = 'en_US';
        $collection = $repository->findOneByCode($code, $localeCode);

        self::assertInstanceOf(CollectionInterface::class, $collection);
    }

    public function test_it_finds_by_codes_and_locale(): void
    {
        $this->loadFixturesFromFile('CollectionRepositoryTest/test_it_finds_collection_by_codes_and_locale.yml');

        $repository = $this->getRepository();

        $codes = 'collection1-code,collection2-code';
        $collections = $repository->findByCodes($codes);

        self::assertIsArray($collections);
        self::assertCount(2, $collections);
    }

    private function getRepository(): CollectionRepositoryInterface
    {
        /** @var CollectionRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(CollectionInterface::class);

        return $repository;
    }
}
