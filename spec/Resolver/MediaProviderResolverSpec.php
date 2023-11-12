<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\MediaProvider\ProviderInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolver;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Webmozart\Assert\InvalidArgumentException;

final class MediaProviderResolverSpec extends ObjectBehavior
{
    public function let(ServiceRegistryInterface $providerRegistry)
    {
        $this->beConstructedWith($providerRegistry);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MediaProviderResolver::class);
        $this->shouldImplement(MediaProviderResolverInterface::class);
    }

    public function it_resolves_provider_for_media(
        ServiceRegistryInterface $providerRegistry,
        MediaInterface $media,
        ProviderInterface $provider
    ) {
        $mediaType = 'image';
        $media->getType()->willReturn($mediaType);

        $providerRegistry->get($mediaType)->willReturn($provider);

        $this->resolveProvider($media)->shouldReturn($provider);
    }

    public function it_throws_exception_when_media_type_is_null(
        MediaInterface $media
    ) {
        $media->getType()->willReturn(null);

        $this->shouldThrow(InvalidArgumentException::class)->during('resolveProvider', [$media]);
    }
}
