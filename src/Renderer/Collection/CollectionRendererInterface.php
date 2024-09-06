<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\Collection;

use Sylius\CmsPlugin\Entity\CollectionInterface;

interface CollectionRendererInterface
{
    public function render(CollectionInterface $collection, ?int $countToRender = null): string;

    public function supports(CollectionInterface $collection): bool;
}
