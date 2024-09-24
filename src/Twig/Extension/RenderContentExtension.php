<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Extension;

use Sylius\CmsPlugin\Twig\Runtime\RenderContentRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RenderContentExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('sylius_cms_render_content', [RenderContentRuntime::class, 'renderContent'], ['is_safe' => ['html']]),
        ];
    }
}
