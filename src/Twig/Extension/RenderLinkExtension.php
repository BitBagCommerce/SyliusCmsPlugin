<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
