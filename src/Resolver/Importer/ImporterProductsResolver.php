<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver\Importer;

use Sylius\CmsPlugin\Assigner\ProductsAssignerInterface;
use Sylius\CmsPlugin\Entity\ProductsAwareInterface;

final class ImporterProductsResolver implements ImporterProductsResolverInterface
{
    public function __construct(private ProductsAssignerInterface $productsAssigner)
    {
    }

    public function resolve(ProductsAwareInterface $productsAware, ?string $productsRow): void
    {
        if (null === $productsRow) {
            return;
        }

        $productsCodes = explode(',', $productsRow);
        $productsCodes = array_map(static function (string $element): string {
            return trim($element);
        }, $productsCodes);

        $this->productsAssigner->assign($productsAware, $productsCodes);
    }
}
