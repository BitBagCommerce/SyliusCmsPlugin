<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity\Trait;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\TaxonInterface;

trait ProductsInTaxonsAwareTrait
{
    /** @var Collection|TaxonInterface[] */
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
}
