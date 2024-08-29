<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer;

use Sylius\CmsPlugin\Entity\CollectionInterface;

interface CollectionRendererStrategyInterface
{
    public function render(CollectionInterface $collection, ?int $countToRender = null): string;
}
