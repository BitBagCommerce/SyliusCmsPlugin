<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver;

use Sylius\CmsPlugin\Entity\CollectionInterface;

interface CollectionResourceResolverInterface
{
    public function findOrLog(string $code): ?CollectionInterface;
}
