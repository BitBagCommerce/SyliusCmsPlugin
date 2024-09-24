<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface CollectibleInterface
{
    public function initializeCollectionsCollection(): void;

    /**
     * @return Collection|CollectionInterface[]
     */
    public function getCollections(): ?Collection;

    public function hasCollection(CollectionInterface $collection): bool;

    public function addCollection(CollectionInterface $collection): void;

    public function removeCollection(CollectionInterface $collection): void;
}
