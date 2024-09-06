<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Assigner;

use Sylius\CmsPlugin\Entity\ProductsAwareInterface;

interface ProductsAssignerInterface
{
    public function assign(ProductsAwareInterface $productsAware, array $productsCodes): void;
}
