<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity\Trait;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\CmsPlugin\Entity\Block;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Entity\Page;

/**
 * @property Collection $contentElements
 */
trait ContentElementsAwareTrait
{
    protected Collection $contentElements;

    public function initializeContentElementsCollection(): void
    {
        $this->contentElements = new ArrayCollection();
    }

    public function getContentElements(): Collection
    {
        return $this->contentElements;
    }

    public function hasContentElement(ContentConfigurationInterface $contentElement): bool
    {
        return $this->contentElements->contains($contentElement);
    }

    public function addContentElement(ContentConfigurationInterface $contentElement): void
    {
        if (!$this->hasContentElement($contentElement)) {
            /** @phpstan-var Block|Page $this */
            if ($this instanceof Block) {
                $contentElement->setBlock($this);
            } elseif ($this instanceof Page) {
                $contentElement->setPage($this);
            }

            $this->contentElements->add($contentElement);
        }
    }

    public function removeContentElement(ContentConfigurationInterface $contentElement): void
    {
        if ($this->hasContentElement($contentElement)) {
            $this->contentElements->removeElement($contentElement);

            /** @phpstan-var Block|Page $this */
            if ($this instanceof Block) {
                $contentElement->setBlock(null);
            } elseif ($this instanceof Page) {
                $contentElement->setPage(null);
            }
        }
    }
}
