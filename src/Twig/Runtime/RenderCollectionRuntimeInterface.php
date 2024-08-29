<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Runtime;

interface RenderCollectionRuntimeInterface
{
    public function renderCollection(string $code, ?int $countToRender = null, ?string $template = null): string;
}
