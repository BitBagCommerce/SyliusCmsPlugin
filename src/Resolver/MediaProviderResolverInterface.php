<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver;

use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\MediaProvider\ProviderInterface;

interface MediaProviderResolverInterface
{
    public function resolveProvider(MediaInterface $media): ProviderInterface;
}
