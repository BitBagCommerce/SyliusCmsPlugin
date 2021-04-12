<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderProductPagesRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RenderProductPagesExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('bitbag_cms_render_product_pages', [RenderProductPagesRuntime::class, 'renderProductPages'], ['is_safe' => ['html']]),
        ];
    }

    public function renderProductPages(ProductInterface $product, ?string $sectionCode = null, ?string $date = null): string
    {
        $channelCode = $this->channelContext->getChannel()->getCode();

        $parsedDate = null;
        if (!empty($date)) {
            $parsedDate = new \DateTimeImmutable($date);
        }

        if (null !== $sectionCode) {
            $pages = $this->pageRepository->findByProductAndSectionCode($product, $sectionCode, $channelCode, $parsedDate);
        } else {
            $pages = $this->pageRepository->findByProduct($product, $channelCode, $parsedDate);
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
