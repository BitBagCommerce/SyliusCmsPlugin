<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Assigner\TaxonsAssigner;
use BitBag\SyliusCmsPlugin\Assigner\TaxonsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\TaxonAwareInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;

final class TaxonsAssignerSpec extends ObjectBehavior
{
    public function let(TaxonRepositoryInterface $taxonRepository): void
    {
        $this->beConstructedWith($taxonRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TaxonsAssigner::class);
    }

    public function it_implements_taxons_assigner_interface(): void
    {
        $this->shouldHaveType(TaxonsAssignerInterface::class);
    }

    public function it_assigns_taxons(
        TaxonRepositoryInterface $taxonRepository,
        TaxonInterface $mugsTaxon,
        TaxonInterface $stickersTaxon,
        TaxonAwareInterface $taxonsAware,
    ): void {
        $taxonRepository->findOneBy(['code' => 'mugs'])->willReturn($mugsTaxon);
        $taxonRepository->findOneBy(['code' => 'stickers'])->willReturn($stickersTaxon);

        $taxonsAware->addTaxon($mugsTaxon)->shouldBeCalled();
        $taxonsAware->addTaxon($stickersTaxon)->shouldBeCalled();

        $this->assign($taxonsAware, ['mugs', 'stickers']);
    }
}
