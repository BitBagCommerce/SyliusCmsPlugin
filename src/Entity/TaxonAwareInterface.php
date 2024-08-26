<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\TaxonInterface;

interface TaxonAwareInterface
{
    public function initializeTaxonCollection(): void;

    public function getTaxons(): Collection;

    public function hasTaxon(TaxonInterface $taxon): bool;

    public function addTaxon(TaxonInterface $taxon): void;

    public function removeTaxon(TaxonInterface $taxon): void;
}
