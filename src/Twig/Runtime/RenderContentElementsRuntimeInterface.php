<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Runtime;

use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Entity\PageInterface;

interface RenderContentElementsRuntimeInterface
{
    public function render(BlockInterface|PageInterface $item): string;
}
