<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @property Collection $contentElements
 */
trait ContentConfigurationAwareTrait
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
