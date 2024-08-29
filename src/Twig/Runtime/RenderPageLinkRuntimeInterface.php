<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Runtime;

use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

interface RenderPageLinkRuntimeInterface extends RuntimeExtensionInterface
{
    public function renderLinkForCode(
        Environment $environment,
        string $code,
        array $options = [],
        ?string $template = null,
    ): string;

    public function getLinkForCode(string $code, array $options = []): string;
}
