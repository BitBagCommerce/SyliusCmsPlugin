<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Processor;

interface ImportProcessorInterface
{
    public function process(string $resourceName, string $filePath): void;
}
