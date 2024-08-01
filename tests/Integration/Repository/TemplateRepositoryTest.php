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
use BitBag\SyliusCmsPlugin\Entity\TemplateInterface;
use BitBag\SyliusCmsPlugin\Repository\TemplateRepositoryInterface;

class TemplateRepositoryTest extends JsonApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_finds_template_page_by_name_part(): void
    {
        $this->loadFixturesFromFile('TemplateRepositoryTest/test_it_finds_template_by_name.yml');

        $repository = $this->getRepository();

        $phrase = 'template';
        $type = 'page';
        $template = $repository->findTemplatesByNamePart($phrase, $type);

        self::assertIsArray($template);
        self::assertCount(3, $template);
    }

    private function getRepository(): TemplateRepositoryInterface
    {
        /** @var TemplateRepositoryInterface $repository */
        $repository = $this->getEntityManager()->getRepository(TemplateInterface::class);

        return $repository;
    }
}
