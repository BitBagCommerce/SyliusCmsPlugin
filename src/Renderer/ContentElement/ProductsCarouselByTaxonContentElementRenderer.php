<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Renderer\ContentElement;

use BitBag\SyliusCmsPlugin\Entity\ContentConfigurationInterface;
use BitBag\SyliusCmsPlugin\Form\Type\ContentElements\ProductsCarouselByTaxonContentElementType;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Twig\Environment;

final class ProductsCarouselByTaxonContentElementRenderer implements ContentElementRendererInterface
{
    public function __construct(
        private Environment $twig,
        private ProductRepositoryInterface $productRepository,
        private TaxonRepositoryInterface $taxonRepository,
    ) {
    }

    public function supports(ContentConfigurationInterface $contentConfiguration): bool
    {
        return ProductsCarouselByTaxonContentElementType::TYPE === $contentConfiguration->getType();
    }

    public function render(ContentConfigurationInterface $contentConfiguration): string
    {
        $taxonCode = $contentConfiguration->getConfiguration()['products_carousel_by_taxon'];

        /** @var TaxonInterface $taxon */
        $taxon = $this->taxonRepository->findOneBy(['code' => $taxonCode]);
        if (null === $taxon) {
            return '';
        }

        $products = $this->productRepository->findByTaxon($taxon);

        return $this->twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_products_carousel.html.twig',
            'products' => $products,
        ]);
    }
}
