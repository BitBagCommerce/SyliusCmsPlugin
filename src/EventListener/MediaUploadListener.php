<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\EventListener;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Webmozart\Assert\Assert;

final class MediaUploadListener
{
    /** @var MediaProviderResolverInterface */
    private $mediaProviderResolver;

    public function __construct(MediaProviderResolverInterface $mediaProviderResolver)
    {
        $this->mediaProviderResolver = $mediaProviderResolver;
    }

    public function uploadMedia(ResourceControllerEvent $event): void
    {
        /** @var MediaInterface $media */
        $media = $event->getSubject();

        Assert::isInstanceOf($media, MediaInterface::class);

        $this->mediaProviderResolver->resolveProvider($media)->upload($media);
    }
}
