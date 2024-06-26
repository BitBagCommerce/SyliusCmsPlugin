<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Runtime;

use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Sorter\SectionsSorterInterface;
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
        private SectionsSorterInterface $sectionsSorter,
    ) {
    }

    public function renderProductPages(ProductInterface $product, string $sectionCode = null): string
    {
        $channelCode = $this->channelContext->getChannel()->getCode();
        Assert::notNull($channelCode, 'Channel code for channel is null');
        if (null !== $sectionCode) {
            $pages = $this->pageRepository->findByProductAndSectionCode($product, $sectionCode, $channelCode, null);
        } else {
            $pages = $this->pageRepository->findByProduct($product, $channelCode, null);
        }

        $data = $this->sectionsSorter->sortBySections($pages);

        return $this->templatingEngine->render('@BitBagSyliusCmsPlugin/Shop/Product/_pagesBySection.html.twig', [
            'data' => $data,
        ]);
    }
}
