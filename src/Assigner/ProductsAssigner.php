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
    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function assign(ProductsAwareInterface $productsAware, array $productsCodes): void
    {
        foreach ($productsCodes as $productCode) {
            /** @var ProductInterface $product */
            $product = $this->productRepository->findOneBy(['code' => $productCode]);

            Assert::notNull($product, sprintf('Product with %s code not found.', $productCode));
            $productsAware->addProduct($product);
        }
    }
}
