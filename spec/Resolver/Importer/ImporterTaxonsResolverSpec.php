<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Resolver\Importer;

use BitBag\SyliusCmsPlugin\Assigner\TaxonsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\TaxonAwareInterface;
use BitBag\SyliusCmsPlugin\Resolver\Importer\ImporterTaxonsResolver;
use PhpSpec\ObjectBehavior;

final class ImporterTaxonsResolverSpec extends ObjectBehavior
{
    public function let(TaxonsAssignerInterface $taxonsAssigner)
    {
        $this->beConstructedWith($taxonsAssigner);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ImporterTaxonsResolver::class);
    }

    public function it_resolves_taxons_for_taxon_aware_entity(
        TaxonsAssignerInterface $taxonsAssigner,
        TaxonAwareInterface $taxonsAware,
    ) {
        $taxonsRow = 'taxon_code_1, taxon_code_2';
        $taxonsAssigner->assign($taxonsAware, ['taxon_code_1', 'taxon_code_2'])->shouldBeCalled();

        $this->resolve($taxonsAware, $taxonsRow);
    }

    public function it_does_not_assign_taxons_when_taxons_row_is_null(
        TaxonsAssignerInterface $taxonsAssigner,
        TaxonAwareInterface $taxonsAware,
    ) {
        $taxonsAssigner->assign($taxonsAware, [])->shouldNotBeCalled();

        $this->resolve($taxonsAware, null);
    }
}
