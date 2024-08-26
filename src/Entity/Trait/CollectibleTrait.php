<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity\Trait;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\CmsPlugin\Entity\Block;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Entity\Media;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Entity\Page;
use Sylius\CmsPlugin\Entity\PageInterface;

trait CollectibleTrait
{
    protected Collection $collections;

    public function initializeCollectionsCollection(): void
    {
        $this->collections = new ArrayCollection();
    }

    public function getCollections(): ?Collection
    {
        return $this->collections;
    }

    public function hasCollection(CollectionInterface $collection): bool
    {
        return $this->collections->contains($collection);
    }

    public function addCollection(CollectionInterface $collection): void
    {
        if (false === $this->hasCollection($collection)) {
            $this->collections->add($collection);

            /** @phpstan-var Block|Page|Media $this */
            if ($this instanceof PageInterface) {
                $collection->addPage($this);
            } elseif ($this instanceof BlockInterface) {
                $collection->addBlock($this);
            } elseif ($this instanceof MediaInterface) {
                $collection->addMedium($this);
            }
        }
    }

    public function removeCollection(CollectionInterface $collection): void
    {
        if (true === $this->hasCollection($collection)) {
            $this->collections->removeElement($collection);
            /** @phpstan-var Block|Page|Media $this */
            if ($this instanceof PageInterface) {
                $collection->removePage($this);
            } elseif ($this instanceof BlockInterface) {
                $collection->removeBlock($this);
            } elseif ($this instanceof MediaInterface) {
                $collection->removeMedium($this);
            }
        }
    }
}
