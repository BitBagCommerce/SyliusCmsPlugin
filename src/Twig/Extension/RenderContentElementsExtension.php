<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Extension;

use Sylius\CmsPlugin\Twig\Runtime\RenderContentElementsRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RenderContentElementsExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'sylius_cms_render_content_elements',
                [RenderContentElementsRuntime::class, 'render'],
                ['is_safe' => ['html']],
            ),
        ];
    }
}
