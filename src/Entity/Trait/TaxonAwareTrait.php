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

trait TaxonAwareTrait
{
    /** @var Collection|TaxonInterface[] */
    protected array|Collection $taxons;

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
}
