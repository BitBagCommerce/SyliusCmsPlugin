<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer;

use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Entity\PageInterface;

interface ContentElementRendererStrategyInterface
{
    public function render(BlockInterface|PageInterface $item): string;
}
