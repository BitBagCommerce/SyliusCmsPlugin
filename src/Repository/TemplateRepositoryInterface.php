<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Repository;

interface TemplateRepositoryInterface
{
    public function findTemplatesByNamePart(string $phrase, string $type): array;
}
