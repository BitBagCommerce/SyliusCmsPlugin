<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Assigner\ProductsInTaxonsAssigner;
use BitBag\SyliusCmsPlugin\Assigner\ProductsInTaxonsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\ProductsInTaxonsAwareInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;

final class ProductsInTaxonsAssignerSpec extends ObjectBehavior
{
    public function let(TaxonRepositoryInterface $taxonRepository)
    {
        $this->beConstructedWith($taxonRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ProductsInTaxonsAssigner::class);
    }

    public function it_implements_products_in_taxons_assigner_interface()
    {
        $this->shouldImplement(ProductsInTaxonsAssignerInterface::class);
    }

    public function it_assigns_taxons_to_products_in_taxons_aware_entity(
        TaxonRepositoryInterface $taxonRepository,
        ProductsInTaxonsAwareInterface $productsInTaxonsAware,
        TaxonInterface $taxon1,
        TaxonInterface $taxon2
    ) {
        $taxon1->getCode()->willReturn('taxon_code_1');
        $taxon2->getCode()->willReturn('taxon_code_2');

        $taxonRepository->findOneBy(['code' => 'taxon_code_1'])->willReturn($taxon1);
        $taxonRepository->findOneBy(['code' => 'taxon_code_2'])->willReturn($taxon2);

        $productsInTaxonsAware->addProductsInTaxon($taxon1)->shouldBeCalled();
        $productsInTaxonsAware->addProductsInTaxon($taxon2)->shouldBeCalled();

        $this->assign($productsInTaxonsAware, ['taxon_code_1', 'taxon_code_2']);
    }
}
