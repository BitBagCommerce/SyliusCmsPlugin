<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Assigner\ProductsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\ProductsAwareInterface;

final class ImporterProductsResolver implements ImporterProductsResolverInterface
{
    /** @var ProductsAssignerInterface */
    private $productsAssigner;

    public function __construct(ProductsAssignerInterface $productsAssigner)
    {
        $this->productsAssigner = $productsAssigner;
    }

    public function resolve(ProductsAwareInterface $productsAware, ?string $productsRow): void
    {
        if (null === $productsRow) {
            return;
        }

        $productsCodes = explode(',', $productsRow);
        $productsCodes = array_map(function (string $element): string {
            return trim($element);
        }, $productsCodes);

        $this->productsAssigner->assign($productsAware, $productsCodes);
    }
}
