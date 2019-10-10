<?php

namespace spec\BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Assigner\TaxonsAssigner;
use BitBag\SyliusCmsPlugin\Assigner\TaxonsAssignerInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use BitBag\SyliusCmsPlugin\Entity\TaxonAwareInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\TaxonInterface;

final class TaxonsAssignerSpec extends ObjectBehavior
{
    function let(TaxonRepositoryInterface $taxonRepository): void
    {
        $this->beConstructedWith($taxonRepository);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(TaxonsAssigner::class);
    }

    function it_implements_taxons_assigner_interface(): void
    {
        $this->shouldHaveType(TaxonsAssignerInterface::class);
    }

    function it_assigns_taxons(
        TaxonRepositoryInterface $taxonRepository,
        TaxonInterface $mugsTaxon,
        TaxonInterface $stickersTaxon,
        TaxonAwareInterface $taxonsAware
    ): void
    {
        $taxonRepository->findOneBy(['code' => 'mugs'])->willReturn($mugsTaxon);
        $taxonRepository->findOneBy(['code' => 'stickers'])->willReturn($stickersTaxon);

        $taxonsAware->addTaxon($mugsTaxon)->shouldBeCalled();
        $taxonsAware->addTaxon($stickersTaxon)->shouldBeCalled();

        $this->assign($taxonsAware, ['mugs', 'stickers']);
    }
}
