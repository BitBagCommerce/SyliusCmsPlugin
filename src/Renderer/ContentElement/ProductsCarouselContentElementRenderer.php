<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\ContentElement;

use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\ProductsCarouselContentElementType;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;

final class ProductsCarouselContentElementRenderer extends AbstractContentElement
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    public function supports(ContentConfigurationInterface $contentConfiguration): bool
    {
        return ProductsCarouselContentElementType::TYPE === $contentConfiguration->getType();
    }

    public function render(ContentConfigurationInterface $contentConfiguration): string
    {
        $configuration = $contentConfiguration->getConfiguration();
        $productsCodes = $configuration['products_carousel']['products'];
        $products = $this->productRepository->findBy(['code' => $productsCodes]);
        if (empty($products)) {
            return '';
        }

        return $this->twig->render('@SyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => $this->template,
            'products' => $products,
        ]);
    }
}
