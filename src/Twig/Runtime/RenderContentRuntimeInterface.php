<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Runtime;

use Sylius\CmsPlugin\Entity\ContentableInterface;
use Twig\Extension\RuntimeExtensionInterface;

interface RenderContentRuntimeInterface extends RuntimeExtensionInterface
{
    public function renderContent(ContentableInterface $contentableResource): string;
}
