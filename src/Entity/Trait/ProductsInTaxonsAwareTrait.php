<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity\Trait;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\TaxonInterface;

trait ProductsInTaxonsAwareTrait
{
    protected Collection $productsInTaxons;

    public function initializeProductsInTaxonsCollection(): void
    {
        $this->productsInTaxons = new ArrayCollection();
    }

    public function getProductsInTaxons(): Collection
    {
        return $this->productsInTaxons;
    }

    public function hasProductsInTaxon(TaxonInterface $taxon): bool
    {
        return $this->productsInTaxons->contains($taxon);
    }

    public function addProductsInTaxon(TaxonInterface $taxon): void
    {
        if (false === $this->hasProductsInTaxon($taxon)) {
            $this->productsInTaxons->add($taxon);
        }
    }

    public function removeProductsInTaxon(TaxonInterface $taxon): void
    {
        if (true === $this->hasProductsInTaxon($taxon)) {
            $this->productsInTaxons->removeElement($taxon);
        }
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
