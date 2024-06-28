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
 * @property Collection $contents
 */
trait ContentConfigurationAwareTrait
{
    protected Collection $contents;

    public function initializeContentsCollection(): void
    {
        $this->contents = new ArrayCollection();
    }

    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function hasContent(ContentConfigurationInterface $contentItem): bool
    {
        return $this->contents->contains($contentItem);
    }

    public function addContent(ContentConfigurationInterface $contentItem): void
    {
        if (!$this->hasContent($contentItem)) {
            /** @phpstan-var Block|Page $this */
            if ($this instanceof Block) {
                $contentItem->setBlock($this);
            } elseif ($this instanceof Page) {
                $contentItem->setPage($this);
            }

            $this->contents->add($contentItem);
        }
    }

    public function removeContent(ContentConfigurationInterface $contentItem): void
    {
        if ($this->hasContent($contentItem)) {
            $this->contents->removeElement($contentItem);

            /** @phpstan-var Block|Page $this */
            if ($this instanceof Block) {
                $contentItem->setBlock(null);
            } elseif ($this instanceof Page) {
                $contentItem->setPage(null);
            }
        }
    }
}