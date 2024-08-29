<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Assigner;

use Sylius\CmsPlugin\Entity\TaxonAwareInterface;

interface TaxonsAssignerInterface
{
    public function assign(TaxonAwareInterface $taxonAware, array $taxonCodes): void;
}
