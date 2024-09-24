<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity\Trait;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\TaxonInterface;

trait TaxonAwareTrait
{
    protected Collection $taxons;

    public function initializeTaxonCollection(): void
    {
        $this->taxons = new ArrayCollection();
    }

    public function getTaxons(): Collection
    {
        return $this->taxons;
    }

    public function hasTaxon(TaxonInterface $taxon): bool
    {
        return $this->taxons->contains($taxon);
    }

    public function addTaxon(TaxonInterface $taxon): void
    {
        if (false === $this->hasTaxon($taxon)) {
            $this->taxons->add($taxon);
        }
    }

    public function removeTaxon(TaxonInterface $taxon): void
    {
        if (true === $this->hasTaxon($taxon)) {
            $this->taxons->removeElement($taxon);
        }
    }

    public function canBeDisplayedForTaxon(TaxonInterface $taxon): bool
    {
        return $this->hasTaxon($taxon);
    }
}
