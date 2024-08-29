<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Runtime;

use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Renderer\ContentElementRendererStrategyInterface;

final class RenderContentElementsRuntime implements RenderContentElementsRuntimeInterface
{
    public function __construct(private ContentElementRendererStrategyInterface $contentElementRendererStrategy)
    {
    }

    public function render(BlockInterface|PageInterface $item): string
    {
        return $this->contentElementRendererStrategy->render($item);
    }
}
