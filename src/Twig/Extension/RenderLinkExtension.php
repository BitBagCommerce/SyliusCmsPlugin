<?php

/*
 * Created by Florian Merle - Dedi Agency <florian.merle@dedi-agency.com> <florian.david.merle@gmail.com>
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderLinkRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RenderLinkExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('bitbag_cms_render_link_for_code', [RenderLinkRuntime::class, 'renderLinkForCode'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
            new TwigFunction('bitbag_cms_get_link_for_code', [RenderLinkRuntime::class, 'getLinkForCode']),
        ];
    }
}
