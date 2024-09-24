<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\TaxonInterface;

interface ProductsInTaxonsAwareInterface
{
    public function initializeProductsInTaxonsCollection(): void;

    public function getProductsInTaxons(): Collection;

    public function hasProductsInTaxon(TaxonInterface $taxon): bool;

    public function addProductsInTaxon(TaxonInterface $taxon): void;

    public function removeProductsInTaxon(TaxonInterface $taxon): void;
}
