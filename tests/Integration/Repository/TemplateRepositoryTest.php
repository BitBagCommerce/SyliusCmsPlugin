<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Integration\Repository;

use ApiTestCase\JsonApiTestCase;
use Sylius\CmsPlugin\Entity\TemplateInterface;
use Sylius\CmsPlugin\Repository\TemplateRepositoryInterface;

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

    public function test_it_finds_template_block_by_name_part(): void
    {
        $this->loadFixturesFromFile('TemplateRepositoryTest/test_it_finds_template_by_name.yml');

        $repository = $this->getRepository();

        $phrase = 'template';
        $type = 'block';
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
