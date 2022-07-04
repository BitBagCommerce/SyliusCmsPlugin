<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Twig\Runtime;

use BitBag\SyliusCmsPlugin\DataCollector\MediaRenderingEventRecorderInterface;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\MediaProvider\ProviderInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaResourceResolverInterface;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderMediaRuntime;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderMediaRuntimeInterface;
use PhpSpec\ObjectBehavior;

final class RenderMediaRuntimeSpec extends ObjectBehavior
{
    function let(
        MediaProviderResolverInterface $mediaProviderResolver,
        MediaResourceResolverInterface $mediaResourceResolver,
        MediaRenderingEventRecorderInterface $mediaRenderingHistory
    ): void {
        $this->beConstructedWith($mediaProviderResolver, $mediaResourceResolver, $mediaRenderingHistory);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderMediaRuntime::class);
    }

    function it_implements_render_media_runtime_interface(): void
    {
        $this->shouldHaveType(RenderMediaRuntimeInterface::class);
    }

    function it_renders_media(
        MediaResourceResolverInterface $mediaResourceResolver,
        MediaProviderResolverInterface $mediaProviderResolver,
        ProviderInterface $provider,
        MediaInterface $media,
        MediaRenderingEventRecorderInterface $mediaRenderingHistory
    ): void {
        $mediaResourceResolver->findOrLog('bitbag')->willReturn($media);

        $mediaRenderingHistory->recordRenderingMediaEvents($media)
        ;
        $provider->render($media, null)->willReturn('content');
        $mediaProviderResolver->resolveProvider($media)->willReturn($provider);

        $this->renderMedia('bitbag')->shouldReturn('content');
    }
}
