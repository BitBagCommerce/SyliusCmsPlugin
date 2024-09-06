<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Resolver\Importer;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Assigner\TaxonsAssignerInterface;
use Sylius\CmsPlugin\Entity\TaxonAwareInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterTaxonsResolver;

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
