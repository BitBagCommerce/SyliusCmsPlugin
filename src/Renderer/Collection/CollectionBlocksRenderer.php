<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\Collection;

use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Renderer\ContentElementRendererStrategyInterface;
use Sylius\CmsPlugin\Sorter\SorterById;
use Webmozart\Assert\Assert;

final class CollectionBlocksRenderer implements CollectionRendererInterface
{
    public function __construct(private ContentElementRendererStrategyInterface $contentElementRendererStrategy)
    {
    }

    public function render(CollectionInterface $collection, ?int $countToRender = null): string
    {
        $content = '';
        $iterator = 0;
        Assert::notNull($collection->getBlocks());
        /** @var BlockInterface $block */
        foreach (SorterById::sort($collection->getBlocks()->toArray()) as $block) {
            $content .= $this->contentElementRendererStrategy->render($block);
            if (++$iterator === $countToRender) {
                break;
            }
        }

        return $content;
    }

    public function supports(CollectionInterface $collection): bool
    {
        return 0 < $collection->getBlocks()?->count();
    }
}
