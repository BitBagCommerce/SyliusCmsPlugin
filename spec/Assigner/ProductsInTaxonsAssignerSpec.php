<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Assigner;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Assigner\ProductsInTaxonsAssigner;
use Sylius\CmsPlugin\Assigner\ProductsInTaxonsAssignerInterface;
use Sylius\CmsPlugin\Entity\ProductsInTaxonsAwareInterface;
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
        TaxonInterface $taxon2,
    ) {
        $taxon1->getCode()->willReturn('taxon_code_1');
        $taxon2->getCode()->willReturn('taxon_code_2');

        $taxonRepository->findBy(['code' => ['taxon_code_1', 'taxon_code_2']])->willReturn([$taxon1, $taxon2]);

        $productsInTaxonsAware->addProductsInTaxon($taxon1)->shouldBeCalled();
        $productsInTaxonsAware->addProductsInTaxon($taxon2)->shouldBeCalled();

        $this->assign($productsInTaxonsAware, ['taxon_code_1', 'taxon_code_2']);
    }
}
