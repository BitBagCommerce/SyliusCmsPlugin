<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Sylius\Component\Core\Model\ProductInterface;

interface BlockProductAwareInterface
{
    public function canBeDisplayedForProduct(ProductInterface $product): bool;

    public function canBeDisplayedForProductInTaxon(ProductInterface $product): bool;
}
