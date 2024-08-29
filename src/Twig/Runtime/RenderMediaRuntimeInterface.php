<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

interface RenderMediaRuntimeInterface extends RuntimeExtensionInterface
{
    public function renderMedia(string $code): string;
}
