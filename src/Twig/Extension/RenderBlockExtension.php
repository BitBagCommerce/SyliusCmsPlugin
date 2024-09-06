<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Extension;

use Sylius\CmsPlugin\Twig\Runtime\RenderBlockRuntimeInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RenderBlockExtension extends AbstractExtension
{
    public function __construct(private RenderBlockRuntimeInterface $blockRuntime)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('sylius_cms_render_block', [$this->blockRuntime, 'renderBlock'], ['is_safe' => ['html']]),
        ];
    }
}
