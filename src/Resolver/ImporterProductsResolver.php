<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
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
