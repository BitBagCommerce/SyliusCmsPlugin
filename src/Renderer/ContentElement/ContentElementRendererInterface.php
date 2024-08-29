<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\ContentElement;

use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;

interface ContentElementRendererInterface
{
    public function supports(ContentConfigurationInterface $contentConfiguration): bool;

    public function render(ContentConfigurationInterface $contentConfiguration): string;
}
