<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Runtime;

use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Sorter\CollectionsSorterInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Twig\Environment;
use Webmozart\Assert\Assert;

final class RenderProductPagesRuntime implements RenderProductPagesRuntimeInterface
{
    public function __construct(
        private PageRepositoryInterface $pageRepository,
        private ChannelContextInterface $channelContext,
        private Environment $templatingEngine,
        private CollectionsSorterInterface $collectionsSorter,
    ) {
    }

    public function renderProductPages(ProductInterface $product, string $collectionCode = null): string
    {
        $channelCode = $this->channelContext->getChannel()->getCode();
        Assert::notNull($channelCode, 'Channel code for channel is null');
        if (null !== $collectionCode) {
            $pages = $this->pageRepository->findByProductAndCollectionCode($product, $collectionCode, $channelCode, null);
        } else {
            $pages = $this->pageRepository->findByProduct($product, $channelCode, null);
        }

        $data = $this->collectionsSorter->sortByCollections($pages);

        return $this->templatingEngine->render('@BitBagSyliusCmsPlugin/Shop/Product/_pagesByCollection.html.twig', [
            'data' => $data,
        ]);
    }
}
