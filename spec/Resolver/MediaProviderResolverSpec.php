<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Resolver;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\MediaProvider\ProviderInterface;
use Sylius\CmsPlugin\Resolver\MediaProviderResolver;
use Sylius\CmsPlugin\Resolver\MediaProviderResolverInterface;
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
        ProviderInterface $provider,
    ) {
        $mediaType = 'image';
        $media->getType()->willReturn($mediaType);

        $providerRegistry->get($mediaType)->willReturn($provider);

        $this->resolveProvider($media)->shouldReturn($provider);
    }

    public function it_throws_exception_when_media_type_is_null(
        MediaInterface $media,
    ) {
        $media->getType()->willReturn(null);

        $this->shouldThrow(InvalidArgumentException::class)->during('resolveProvider', [$media]);
    }
}
