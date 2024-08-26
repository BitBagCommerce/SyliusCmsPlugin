<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer\ContentElement;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\TaxonsListContentElementType;
use Sylius\CmsPlugin\Renderer\ContentElement\ContentElementRendererInterface;
use Sylius\CmsPlugin\Renderer\ContentElement\TaxonsListContentElementRenderer;
use Sylius\Component\Core\Model\Taxon;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Twig\Environment;

final class TaxonsListContentElementRendererSpec extends ObjectBehavior
{
    public function let(Environment $twig, TaxonRepositoryInterface $taxonRepository): void
    {
        $this->beConstructedWith($twig, $taxonRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TaxonsListContentElementRenderer::class);
    }

    public function it_implements_content_element_renderer_interface(): void
    {
        $this->shouldImplement(ContentElementRendererInterface::class);
    }

    public function it_supports_taxons_list_content_element_type(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn(TaxonsListContentElementType::TYPE);
        $this->supports($contentConfiguration)->shouldReturn(true);
    }

    public function it_does_not_support_other_content_element_types(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn('other_type');
        $this->supports($contentConfiguration)->shouldReturn(false);
    }

    public function it_renders_taxons_list_content_element(
        Environment $twig,
        TaxonRepositoryInterface $taxonRepository,
        ContentConfigurationInterface $contentConfiguration,
        Taxon $taxon1,
        Taxon $taxon2,
    ): void {
        $contentConfiguration->getConfiguration()->willReturn([
            'taxons_list' => ['taxons' => ['code1', 'code2']],
        ]);

        $taxonRepository->findBy(['code' => ['code1', 'code2']])->willReturn([$taxon1, $taxon2]);

        $twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_taxons_list.html.twig',
            'taxons' => [$taxon1, $taxon2],
        ])->willReturn('rendered template');

        $this->render($contentConfiguration)->shouldReturn('rendered template');
    }
}
