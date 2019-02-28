<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\TaxonInterface;

interface TaxonAwareInterface
{
    public function initializeTaxonCollection(): void;

    /**
     * @return Collection|TaxonInterface[]
     */
    public function getTaxons(): Collection;

    public function hasTaxon(TaxonInterface $taxon): bool;

    public function addTaxon(TaxonInterface $taxon): void;

    public function removeTaxon(TaxonInterface $taxon): void;
}
