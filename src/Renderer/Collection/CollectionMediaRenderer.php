<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\Collection;

use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Sorter\SorterById;
use Sylius\CmsPlugin\Twig\Runtime\RenderMediaRuntimeInterface;
use Webmozart\Assert\Assert;

final class CollectionMediaRenderer implements CollectionRendererInterface
{
    public function __construct(private RenderMediaRuntimeInterface $renderMediaRuntime)
    {
    }

    public function render(CollectionInterface $collection, ?int $countToRender = null): string
    {
        $content = '';
        $iterator = 0;
        Assert::notNull($collection->getMedia());
        /** @var MediaInterface $media */
        foreach (SorterById::sort($collection->getMedia()->toArray()) as $media) {
            Assert::notNull($media->getCode());
            $content .= $this->renderMediaRuntime->renderMedia($media->getCode());
            if (++$iterator === $countToRender) {
                break;
            }
        }

        return $content;
    }

    public function supports(CollectionInterface $collection): bool
    {
        return 0 < $collection->getMedia()?->count();
    }
}
