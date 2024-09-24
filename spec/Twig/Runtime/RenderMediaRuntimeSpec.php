<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Twig\Runtime;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\MediaProvider\ProviderInterface;
use Sylius\CmsPlugin\Resolver\MediaProviderResolverInterface;
use Sylius\CmsPlugin\Resolver\MediaResourceResolverInterface;
use Sylius\CmsPlugin\Twig\Runtime\RenderMediaRuntime;
use Sylius\CmsPlugin\Twig\Runtime\RenderMediaRuntimeInterface;

final class RenderMediaRuntimeSpec extends ObjectBehavior
{
    public function let(
        MediaProviderResolverInterface $mediaProviderResolver,
        MediaResourceResolverInterface $mediaResourceResolver,
    ): void {
        $this->beConstructedWith($mediaProviderResolver, $mediaResourceResolver);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderMediaRuntime::class);
    }

    public function it_implements_render_media_runtime_interface(): void
    {
        $this->shouldHaveType(RenderMediaRuntimeInterface::class);
    }

    public function it_renders_media(
        MediaResourceResolverInterface $mediaResourceResolver,
        MediaProviderResolverInterface $mediaProviderResolver,
        ProviderInterface $provider,
        MediaInterface $media,
    ): void {
        $mediaResourceResolver->findOrLog('sylius_cms')->willReturn($media);
        $provider->render($media, null)->willReturn('content');
        $mediaProviderResolver->resolveProvider($media)->willReturn($provider);

        $this->renderMedia('sylius_cms')->shouldReturn('content');
    }
}
