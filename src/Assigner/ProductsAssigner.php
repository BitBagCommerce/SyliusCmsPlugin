<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Entity\ProductsAwareInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;

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

            if (null !== $product) {
                $productsAware->addProduct($product);
            }
        }
    }
}
