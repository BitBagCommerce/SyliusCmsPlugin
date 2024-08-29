<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\EventListener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\EventListener\MediaUploadListener;
use Sylius\CmsPlugin\MediaProvider\ProviderInterface;
use Sylius\CmsPlugin\Resolver\MediaProviderResolverInterface;

final class MediaUploadListenerSpec extends ObjectBehavior
{
    public function let(MediaProviderResolverInterface $mediaProviderResolver): void
    {
        $this->beConstructedWith($mediaProviderResolver);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MediaUploadListener::class);
    }

    public function it_does_not_upload_if_not_media_instance(
        ResourceControllerEvent $event,
        MediaInterface $media,
        MediaProviderResolverInterface $mediaProviderResolver,
    ): void {
        $event->getSubject()->willReturn(Argument::any());

        $mediaProviderResolver->resolveProvider($media)->shouldNotBeCalled();
    }

    public function it_uploads_media(
        ResourceControllerEvent $event,
        MediaInterface $media,
        MediaProviderResolverInterface $mediaProviderResolver,
        ProviderInterface $provider,
    ): void {
        $event->getSubject()->willReturn($media);
        $mediaProviderResolver->resolveProvider($media)->willReturn($provider);
    }
}
