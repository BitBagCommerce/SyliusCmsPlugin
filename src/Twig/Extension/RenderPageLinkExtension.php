<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderPageLinkRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RenderPageLinkExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('bitbag_cms_render_page_link', [RenderPageLinkRuntime::class, 'renderLinkForCode'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
            new TwigFunction('bitbag_cms_get_page_url', [RenderPageLinkRuntime::class, 'getLinkForCode']),
        ];
    }
}
