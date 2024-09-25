<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Provider;

interface ResourceTemplateProviderInterface
{
    public function getPageTemplates(): array;

    public function getBlockTemplates(): array;
}
