<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\EventListener;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\EventListener\MediaUploadListener;
use BitBag\SyliusCmsPlugin\MediaProvider\ProviderInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;

final class MediaUploadListenerSpec extends ObjectBehavior
{
    public function let(MediaProviderResolverInterface $mediaProviderResolver): void
    {
        $this->beConstructedWith($mediaProviderResolver);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(MediaUploadListener::class);
    }

    function it_does_not_upload_if_not_media_instance(
        ResourceControllerEvent $event,
        MediaInterface $media,
        MediaProviderResolverInterface $mediaProviderResolver
    ): void {
        $event->getSubject()->willReturn(Argument::any());

        $mediaProviderResolver->resolveProvider($media)->shouldNotBeCalled();
    }

    function it_uploads_media(
        ResourceControllerEvent $event,
        MediaInterface $media,
        MediaProviderResolverInterface $mediaProviderResolver,
        ProviderInterface $provider
    ): void {
        $event->getSubject()->willReturn($media);
        $mediaProviderResolver->resolveProvider($media)->willReturn($provider);
    }
}
