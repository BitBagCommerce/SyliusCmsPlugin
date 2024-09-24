<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Assigner;

use Sylius\CmsPlugin\Entity\ProductsInTaxonsAwareInterface;

interface ProductsInTaxonsAssignerInterface
{
    public function assign(ProductsInTaxonsAwareInterface $productsInTaxonsAware, array $taxonCodes): void;
}
