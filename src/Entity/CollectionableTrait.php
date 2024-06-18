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

trait CollectionableTrait
{
    /** @var Collection|CollectionInterface[] */
    protected Collection|array $collections;

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
        }
    }

    public function removeCollection(CollectionInterface $collection): void
    {
        if (true === $this->hasCollection($collection)) {
            $this->collections->removeElement($collection);
        }
    }
}
