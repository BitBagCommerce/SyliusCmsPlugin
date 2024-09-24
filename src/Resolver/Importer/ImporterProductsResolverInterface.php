<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver\Importer;

use Sylius\CmsPlugin\Entity\ProductsAwareInterface;

interface ImporterProductsResolverInterface
{
    public function resolve(ProductsAwareInterface $productsAware, ?string $productsRow): void;
}
