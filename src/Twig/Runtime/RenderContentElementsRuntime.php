<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
