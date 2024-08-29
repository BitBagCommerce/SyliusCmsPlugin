<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver;

use Sylius\CmsPlugin\Entity\BlockInterface;

interface BlockResourceResolverInterface
{
    public function findOrLog(string $code): ?BlockInterface;
}
