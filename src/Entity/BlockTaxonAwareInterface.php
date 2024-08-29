<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Sylius\Component\Core\Model\TaxonInterface;

interface BlockTaxonAwareInterface
{
    public function canBeDisplayedForTaxon(TaxonInterface $taxon): bool;
}
