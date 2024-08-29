<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Assigner;

use Sylius\CmsPlugin\Entity\ProductsAwareInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Webmozart\Assert\Assert;

final class ProductsAssigner implements ProductsAssignerInterface
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public function assign(ProductsAwareInterface $productsAware, array $productsCodes): void
    {
        $products = $this->productRepository->findBy(['code' => $productsCodes]);
        Assert::allIsInstanceOf($products, ProductInterface::class);

        foreach ($products as $product) {
            $productsAware->addProduct($product);
        }
    }
}
