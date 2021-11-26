<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Sorter\SectionsSorter;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderProductPagesRuntime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RenderProductPagesExtension extends AbstractExtension
{
    /** @var Environment */
    private $environment;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var PageRepositoryInterface */
    private $pageRepository;

    public function __construct(
        ChannelContextInterface $channelContext,
        Environment $environment,
        PageRepositoryInterface $pageRepository
    ) {
        $this->environment = $environment;
        $this->channelContext = $channelContext;
        $this->pageRepository = $pageRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('bitbag_cms_render_product_pages', [RenderProductPagesRuntime::class, 'renderProductPages'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws Exception
     */
    public function renderProductPages(
        ProductInterface $product,
        ?string $sectionCode = null,
        ?string $date = null
    ): string {
        /** @var string|null $channelCode */
        $channelCode = $this->channelContext->getChannel()->getCode();
        $parsedDate = null;
        if (null !== $date) {
            $parsedDate = new DateTimeImmutable($date);
        }
        assert(null !== $channelCode);
        if (null !== $sectionCode) {
            $pages = $this->pageRepository->findByProductAndSectionCode($product, $sectionCode, $channelCode, $parsedDate);
        } else {
            $pages = $this->pageRepository->findByProduct($product, $channelCode, $parsedDate);
        }

        $data = $this->sortBySections($pages);

        return $this->environment->render('@BitBagSyliusCmsPlugin/Shop/Product/_pagesBySection.html.twig', [
            'data' => $data,
        ]);
    }

    private function sortBySections(array $pages): array
    {
        $sectionsSorter = new SectionsSorter();

        return $sectionsSorter->sortBySections($pages);
    }
}
