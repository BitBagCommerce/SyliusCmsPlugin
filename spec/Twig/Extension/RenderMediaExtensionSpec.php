<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Media\Provider\ProviderInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaResourceResolverInterface;
use BitBag\SyliusCmsPlugin\Twig\Extension\RenderMediaExtension;
use PhpSpec\ObjectBehavior;

final class RenderMediaExtensionSpec extends ObjectBehavior
{
    function let(
        MediaProviderResolverInterface $mediaProviderResolver,
        MediaResourceResolverInterface $mediaResourceResolver
    ): void {
        $this->beConstructedWith($mediaProviderResolver, $mediaResourceResolver);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderMediaExtension::class);
    }

    function it_extends_twig_extension(): void
    {
        $this->shouldHaveType(\Twig_Extension::class);
    }

    function it_returns_functions(): void
    {
        $functions = $this->getFunctions();

        $functions->shouldHaveCount(1);

        foreach ($functions as $function) {
            $function->shouldHaveType(\Twig_SimpleFunction::class);
        }
    }

    function it_renders_media(
        MediaResourceResolverInterface $mediaResourceResolver,
        MediaProviderResolverInterface $mediaProviderResolver,
        ProviderInterface $provider,
        MediaInterface $media
    ): void {
        $mediaResourceResolver->findOrLog('bitbag')->willReturn($media);
        $provider->render($media)->willReturn('content');
        $mediaProviderResolver->resolveProvider($media)->willReturn($provider);

        $this->renderMedia('bitbag')->shouldReturn('content');
    }
}
