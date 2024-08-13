<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Resolver\Importer;

use BitBag\SyliusCmsPlugin\Assigner\ProductsInTaxonsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\ProductsInTaxonsAwareInterface;
use BitBag\SyliusCmsPlugin\Resolver\Importer\ImporterProductsInTaxonsResolver;
use PhpSpec\ObjectBehavior;

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
