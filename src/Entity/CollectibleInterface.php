<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

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