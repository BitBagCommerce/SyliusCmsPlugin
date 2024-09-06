<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface ContentElementsAwareInterface
{
    public function initializeContentElementsCollection(): void;

    public function getContentElements(): Collection;

    public function hasContentElement(ContentConfigurationInterface $contentElement): bool;

    public function addContentElement(ContentConfigurationInterface $contentElement): void;

    public function removeContentElement(ContentConfigurationInterface $contentElement): void;
}
