<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver;

use Sylius\CmsPlugin\Entity\MediaInterface;

interface MediaResourceResolverInterface
{
    public function findOrLog(string $code): ?MediaInterface;
}
