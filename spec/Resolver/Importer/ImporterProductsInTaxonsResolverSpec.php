<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Resolver\Importer;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Assigner\ProductsInTaxonsAssignerInterface;
use Sylius\CmsPlugin\Entity\ProductsInTaxonsAwareInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterProductsInTaxonsResolver;

final class ImporterProductsInTaxonsResolverSpec extends ObjectBehavior
{
    public function let(ProductsInTaxonsAssignerInterface $productsInTaxonsAssigner)
    {
        $this->beConstructedWith($productsInTaxonsAssigner);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ImporterProductsInTaxonsResolver::class);
    }

    public function it_resolves_taxons_for_products_in_taxons_aware_entity(
        ProductsInTaxonsAssignerInterface $productsInTaxonsAssigner,
        ProductsInTaxonsAwareInterface $productsInTaxonsAware,
    ) {
        $taxonsRow = 'taxon_code_1, taxon_code_2';
        $productsInTaxonsAssigner->assign($productsInTaxonsAware, ['taxon_code_1', 'taxon_code_2'])->shouldBeCalled();

        $this->resolve($productsInTaxonsAware, $taxonsRow);
    }

    public function it_does_not_assign_taxons_when_taxons_row_is_null(
        ProductsInTaxonsAssignerInterface $productsInTaxonsAssigner,
        ProductsInTaxonsAwareInterface $productsInTaxonsAware,
    ) {
        $productsInTaxonsAssigner->assign($productsInTaxonsAware, [])->shouldNotBeCalled();

        $this->resolve($productsInTaxonsAware, null);
    }
}
