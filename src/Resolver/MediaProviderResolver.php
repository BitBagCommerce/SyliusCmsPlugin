<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver;

use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\MediaProvider\ProviderInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Webmozart\Assert\Assert;

final class MediaProviderResolver implements MediaProviderResolverInterface
{
    public function __construct(private ServiceRegistryInterface $providerRegistry)
    {
    }

    public function resolveProvider(MediaInterface $media): ProviderInterface
    {
        Assert::notNull($media->getType());
        /** @var ProviderInterface $provider */
        $provider = $this->providerRegistry->get($media->getType());

        return $provider;
    }
}
