<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Importer;

interface ImporterChainInterface
{
    public function addImporter(ImporterInterface $importer): void;

    public function getImporterForResource(string $resourceCode): ImporterInterface;
}
