<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Entity\Page;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Sorter\SectionsSorter;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderProductPagesRuntime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RenderProductPagesExtension extends AbstractExtension
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Environment
     */
    private $environment;

    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager, Environment $environment)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;
        $this->environment = $environment;
    }


    public function getFunctions(): array
    {
        return [
            new TwigFunction('bitbag_cms_render_product_pages', [RenderProductPagesRuntime::class, 'renderProductPages'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws SyntaxError
     * @throws ContainerExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     * @throws Exception
     */
    public function renderProductPages(
        ProductInterface $product,
        ?string $sectionCode = null,
        ?string $date = null
    ): string {
        $channelCode = $this->container->get('sylius.context.channel')->getChannel();

        $parsedDate = null;
        if (null !== $date) {
            $parsedDate = new DateTimeImmutable($date);
        }

        /** @var PageRepositoryInterface $pageRepository */
        $pageRepository = $this->entityManager->getRepository(Page::class);
        if (null !== $sectionCode) {
            $pages = $pageRepository->findByProductAndSectionCode($product, $sectionCode, $channelCode, $parsedDate);
        } else {
            $pages = $pageRepository->findByProduct($product, $channelCode, $parsedDate);
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
