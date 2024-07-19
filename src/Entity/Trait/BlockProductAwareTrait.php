<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity\Trait;

use Sylius\Component\Core\Model\ProductInterface;

trait BlockProductAwareTrait
{
    public function canBeDisplayedForProduct(ProductInterface $product): bool
    {
        return $this->hasProduct($product);
    }

    public function canBeDisplayedForProductInTaxon(ProductInterface $product): bool
    {
        $taxon = $product->getMainTaxon();
        if (null === $taxon) {
            return false;
        }

        return $this->hasProductsInTaxon($taxon);
    }
}
