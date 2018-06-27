<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\EventListener;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\EventListener\MediaUploadListener;
use BitBag\SyliusCmsPlugin\Media\Provider\ProviderInterface;
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
