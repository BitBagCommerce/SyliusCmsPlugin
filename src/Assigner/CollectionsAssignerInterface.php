<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Assigner;

use Sylius\CmsPlugin\Entity\CollectibleInterface;

interface CollectionsAssignerInterface
{
    public function assign(CollectibleInterface $collectionsAware, array $collectionsCodes): void;
}
