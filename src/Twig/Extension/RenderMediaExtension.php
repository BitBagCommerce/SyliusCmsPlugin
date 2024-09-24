<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Extension;

use Sylius\CmsPlugin\Twig\Runtime\RenderMediaRuntimeInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RenderMediaExtension extends AbstractExtension
{
    public function __construct(private RenderMediaRuntimeInterface $mediaRuntime)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('sylius_cms_render_media', [$this->mediaRuntime, 'renderMedia'], ['is_safe' => ['html']]),
        ];
    }
}
