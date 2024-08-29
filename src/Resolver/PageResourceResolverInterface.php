<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver;

use Sylius\CmsPlugin\Entity\PageInterface;

interface PageResourceResolverInterface
{
    public function findOrLog(string $code): ?PageInterface;
}
