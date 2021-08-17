<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\MediaProvider\ProviderInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

final class MediaProviderResolver implements MediaProviderResolverInterface
{
    /** @var ServiceRegistryInterface */
    private $providerRegistry;

    public function __construct(ServiceRegistryInterface $providerRegistry)
    {
        $this->providerRegistry = $providerRegistry;
    }

    public function resolveProvider(MediaInterface $media): ProviderInterface
    {
        /** @var ProviderInterface $provider */
        $provider = $this->providerRegistry->get($media->getType());

        return $provider;
    }
}
