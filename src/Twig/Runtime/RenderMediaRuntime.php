<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Runtime;

use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaResourceResolverInterface;

final class RenderMediaRuntime implements RenderMediaRuntimeInterface
{
    /** @var MediaProviderResolverInterface */
    private $mediaProviderResolver;

    /** @var MediaResourceResolverInterface */
    private $mediaResourceResolver;

    public function __construct(
        MediaProviderResolverInterface $mediaProviderResolver,
        MediaResourceResolverInterface $mediaResourceResolver
    ) {
        $this->mediaProviderResolver = $mediaProviderResolver;
        $this->mediaResourceResolver = $mediaResourceResolver;
    }

    public function renderMedia(string $code): string
    {
        $media = $this->mediaResourceResolver->findOrLog($code);

        if (null !== $media) {
            return $this->mediaProviderResolver->resolveProvider($media)->render($media);
        }

        return '';
    }
}
