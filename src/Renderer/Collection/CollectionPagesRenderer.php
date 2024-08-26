<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\Collection;

use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Renderer\PageLinkRendererInterface;
use Sylius\CmsPlugin\Sorter\SorterById;
use Webmozart\Assert\Assert;

final class CollectionPagesRenderer implements CollectionRendererInterface
{
    public function __construct(private PageLinkRendererInterface $pageLinkRenderer)
    {
    }

    public function render(CollectionInterface $collection, ?int $countToRender = null): string
    {
        $content = '';
        $iterator = 0;
        Assert::notNull($collection->getPages());
        /** @var PageInterface $page */
        foreach (SorterById::sort($collection->getPages()->toArray(), 'desc') as $page) {
            $content .= $this->pageLinkRenderer->render($page);
            if (++$iterator === $countToRender) {
                break;
            }
        }

        return $content;
    }

    public function supports(CollectionInterface $collection): bool
    {
        return 0 < $collection->getPages()?->count();
    }
}
