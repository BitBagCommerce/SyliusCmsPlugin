<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Importer;

interface ImporterInterface
{
    public function import(array $row): void;

    public function getResourceCode(): string;

    public function cleanup(): void;
}
