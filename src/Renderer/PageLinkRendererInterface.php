<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer;

use Sylius\CmsPlugin\Entity\PageInterface;

interface PageLinkRendererInterface
{
    public function render(PageInterface $page, ?string $template = null): string;
}
