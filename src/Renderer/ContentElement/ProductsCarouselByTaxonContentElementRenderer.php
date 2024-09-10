<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\ContentElement;

use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\ProductsCarouselByTaxonContentElementType;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;

final class ProductsCarouselByTaxonContentElementRenderer extends AbstractContentElement
{
    public function __construct(
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

        /** @var TaxonInterface|null $taxon */
        $taxon = $this->taxonRepository->findOneBy(['code' => $taxonCode]);
        if (null === $taxon) {
            return '';
        }

        $products = $this->productRepository->findByTaxon($taxon);

        return $this->twig->render('@SyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => $this->template,
            'products' => $products,
        ]);
    }
}
