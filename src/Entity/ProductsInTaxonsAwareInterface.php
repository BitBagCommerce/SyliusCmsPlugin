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

interface ProductsInTaxonsAwareInterface
{
    public function initializeProductsInTaxonsCollection(): void;

    public function getProductsInTaxons(): Collection;

    public function hasProductsInTaxon(TaxonInterface $taxon): bool;

    public function addProductsInTaxon(TaxonInterface $taxon): void;

    public function removeProductsInTaxon(TaxonInterface $taxon): void;
}
