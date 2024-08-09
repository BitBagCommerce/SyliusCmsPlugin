<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity\Trait;

use BitBag\SyliusCmsPlugin\Entity\Block;
use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use BitBag\SyliusCmsPlugin\Entity\Media;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Entity\Page;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
            } else if ($this instanceof BlockInterface) {
                $collection->addBlock($this);
            } else if ($this instanceof MediaInterface) {
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
            } else if ($this instanceof BlockInterface) {
                $collection->removeBlock($this);
            } else if ($this instanceof MediaInterface) {
                $collection->removeMedium($this);
            }
        }
    }
}
