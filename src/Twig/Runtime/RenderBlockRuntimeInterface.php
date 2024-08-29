<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

interface RenderBlockRuntimeInterface extends RuntimeExtensionInterface
{
    public function renderBlock(string $code, ?string $template = null): string;
}
