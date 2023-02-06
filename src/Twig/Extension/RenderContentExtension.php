<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderContentRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RenderContentExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('bitbag_cms_render_content', [RenderContentRuntime::class, 'renderContent'], ['is_safe' => ['html']]),
        ];
    }
}
