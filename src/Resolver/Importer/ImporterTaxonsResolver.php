<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
