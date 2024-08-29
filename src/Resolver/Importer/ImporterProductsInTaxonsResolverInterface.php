<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver\Importer;

use Sylius\CmsPlugin\Entity\ProductsInTaxonsAwareInterface;

interface ImporterProductsInTaxonsResolverInterface
{
    public function resolve(ProductsInTaxonsAwareInterface $productsInTaxonsAware, ?string $taxonsRow): void;
}
