<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver\Importer;

use Sylius\CmsPlugin\Entity\TaxonAwareInterface;

interface ImporterTaxonsResolverInterface
{
    public function resolve(TaxonAwareInterface $taxonsAware, ?string $taxonsRow): void;
}
