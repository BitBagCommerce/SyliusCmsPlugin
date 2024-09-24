<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Sorter;

interface CollectionsSorterInterface
{
    public function sortByCollections(array $pages): array;
}
