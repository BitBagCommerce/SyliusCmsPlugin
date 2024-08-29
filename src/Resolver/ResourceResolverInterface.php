<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ResourceResolverInterface
{
    public function getResource(string $identifier, string $factoryMethod = 'createNew'): ResourceInterface;
}
