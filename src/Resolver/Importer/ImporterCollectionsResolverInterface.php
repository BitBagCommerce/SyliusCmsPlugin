<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver\Importer;

use Sylius\CmsPlugin\Entity\CollectibleInterface;

interface ImporterCollectionsResolverInterface
{
    public function resolve(CollectibleInterface $collectionable, ?string $collectionsRow): void;
}
