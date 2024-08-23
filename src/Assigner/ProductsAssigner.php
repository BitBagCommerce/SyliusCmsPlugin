<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Entity\ProductsAwareInterface;
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
