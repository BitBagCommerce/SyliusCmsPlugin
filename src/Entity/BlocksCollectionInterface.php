<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface BlocksCollectionInterface
{
    public function initializeBlocksCollection(): void;

    public function getBlocks(): ?Collection;

    public function hasBlock(BlockInterface $block): bool;

    public function addBlock(BlockInterface $block): void;

    public function removeBlock(BlockInterface $block): void;
}
