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

final class RenderProductPagesRuntime implements RenderProductPagesRuntimeInterface
{
    /** @var PageRepositoryInterface */
    private $pageRepository;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var Environment */
    private $templatingEngine;

    /** @var SectionsSorterInterface */
    private $sectionsSorter;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        ChannelContextInterface $channelContext,
        Environment $templatingEngine,
        SectionsSorterInterface $sectionsSorter
    ) {
        $this->pageRepository = $pageRepository;
        $this->channelContext = $channelContext;
        $this->templatingEngine = $templatingEngine;
        $this->sectionsSorter = $sectionsSorter;
    }

    public function renderProductPages(ProductInterface $product, string $sectionCode = null): string
    {
        $channelCode = $this->channelContext->getChannel()->getCode();

        if (null !== $sectionCode) {
            $pages = $this->pageRepository->findByProductAndSectionCode($product, $sectionCode, $channelCode);
        } else {
            $pages = $this->pageRepository->findByProduct($product, $channelCode);
        }

        $data = $this->sectionsSorter->sortBySections($pages);

        return $this->templatingEngine->render('@BitBagSyliusCmsPlugin/Shop/Product/_pagesBySection.html.twig', [
            'data' => $data,
        ]);
    }
}
