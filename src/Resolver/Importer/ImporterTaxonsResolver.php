<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver\Importer;

use Sylius\CmsPlugin\Assigner\TaxonsAssignerInterface;
use Sylius\CmsPlugin\Entity\TaxonAwareInterface;

final class ImporterTaxonsResolver implements ImporterTaxonsResolverInterface
{
    public function __construct(private TaxonsAssignerInterface $taxonsAssigner)
    {
    }

    public function resolve(TaxonAwareInterface $taxonsAware, ?string $taxonsRow): void
    {
        if (null === $taxonsRow) {
            return;
        }

        $taxonsCodes = explode(',', $taxonsRow);
        $taxonsCodes = array_map(static function (string $element): string {
            return trim($element);
        }, $taxonsCodes);

        $this->taxonsAssigner->assign($taxonsAware, $taxonsCodes);
    }
}
