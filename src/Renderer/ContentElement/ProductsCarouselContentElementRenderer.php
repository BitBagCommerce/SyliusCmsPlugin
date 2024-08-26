<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\ContentElement;

use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\ProductsCarouselContentElementType;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Twig\Environment;

final class ProductsCarouselContentElementRenderer implements ContentElementRendererInterface
{
    public function __construct(
        private Environment $twig,
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

        return $this->twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_products_carousel.html.twig',
            'products' => $products,
        ]);
    }
}
