<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Extension;

use Sylius\CmsPlugin\Twig\Runtime\RenderPageLinkRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RenderPageLinkExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('sylius_cms_render_page_link', [RenderPageLinkRuntime::class, 'renderLinkForCode'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
            new TwigFunction('sylius_cms_get_page_url', [RenderPageLinkRuntime::class, 'getLinkForCode']),
        ];
    }
}
