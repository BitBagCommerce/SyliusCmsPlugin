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

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\Templating\EngineInterface;

final class RenderProductPagesRuntime implements RenderProductPagesRuntimeInterface
{
    /** @var PageRepositoryInterface */
    private $pageRepository;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var EngineInterface */
    private $templatingEngine;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        ChannelContextInterface $channelContext,
        EngineInterface $templatingEngine
    ) {
        $this->pageRepository = $pageRepository;
        $this->channelContext = $channelContext;
        $this->templatingEngine = $templatingEngine;
    }

    public function renderProductPages(ProductInterface $product, string $sectionCode = null): string
    {
        $channelCode = $this->channelContext->getChannel()->getCode();

        if (null !== $sectionCode) {
            $pages = $this->pageRepository->findByProductAndSectionCode($product, $sectionCode, $channelCode);
        } else {
            $pages = $this->pageRepository->findByProduct($product, $channelCode);
        }

        $data = $this->sortBySections($pages);

        return $this->templatingEngine->render('@BitBagSyliusCmsPlugin/Shop/Product/_pagesBySection.html.twig', [
            'data' => $data,
        ]);
    }

    private function sortBySections(array $pages): array
    {
        $result = [];

        /** @var PageInterface $page */
        foreach ($pages as $page) {
            foreach ($page->getSections() as $section) {
                $sectionCode = $section->getCode();
                if (!array_key_exists($sectionCode, $result)) {
                    $result[$sectionCode] = [];
                    $result[$sectionCode]['section'] = $section;
                }

                $result[$sectionCode][] = $page;
            }
        }

        return $result;
    }
}
