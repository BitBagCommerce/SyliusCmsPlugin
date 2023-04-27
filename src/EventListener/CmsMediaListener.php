<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\EventListener;

use BitBag\SyliusCmsPlugin\Entity\Media;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Webmozart\Assert\Assert;

class CmsMediaListener
{
    private CacheManager $imagineCacheManager;

    public function __construct(
        CacheManager $imagineCacheManager
    ) {
        $this->imagineCacheManager = $imagineCacheManager;
    }

    public function postLoad(Media $media, LifecycleEventArgs $event): void
    {
        Assert::notNull($media->getPath());
        $media->imaginePaths['tiny'] = $this->imagineCacheManager->resolve($media->getPath(), 'sylius_admin_product_tiny_thumbnail');
    }
}
