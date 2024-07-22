<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Renderer\ContentElement;

use BitBag\SyliusCmsPlugin\Entity\ContentConfigurationInterface;
use BitBag\SyliusCmsPlugin\Form\Type\ContentElements\ProductsCarouselByTaxonContentElementType;
use BitBag\SyliusCmsPlugin\Renderer\ContentElement\ContentElementRendererInterface;
use BitBag\SyliusCmsPlugin\Renderer\ContentElement\ProductsCarouselByTaxonContentElementRenderer;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Twig\Environment;

final class ProductsCarouselByTaxonContentElementRendererSpec extends ObjectBehavior
{
    public function let(Environment $twig, ProductRepositoryInterface $productRepository, TaxonRepositoryInterface $taxonRepository): void
    {
        $this->beConstructedWith($twig, $productRepository, $taxonRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductsCarouselByTaxonContentElementRenderer::class);
    }

    public function it_implements_content_element_renderer_interface(): void
    {
        $this->shouldImplement(ContentElementRendererInterface::class);
    }

    public function it_supports_products_carousel_by_taxon_content_element_type(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn(ProductsCarouselByTaxonContentElementType::TYPE);
        $this->supports($contentConfiguration)->shouldReturn(true);
    }

    public function it_does_not_support_other_content_element_types(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn('other_type');
        $this->supports($contentConfiguration)->shouldReturn(false);
    }

    public function it_renders_products_carousel_by_taxon_content_element(
        Environment $twig,
        ProductRepositoryInterface $productRepository,
        TaxonRepositoryInterface $taxonRepository,
        ContentConfigurationInterface $contentConfiguration,
        TaxonInterface $taxon,
        Product $product1,
        Product $product2
    ): void
    {
        $contentConfiguration->getConfiguration()->willReturn([
            'products_carousel_by_taxon' => 'taxon_code'
        ]);

        $taxonRepository->findOneBy(['code' => 'taxon_code'])->willReturn($taxon);
        $productRepository->findByTaxon($taxon)->willReturn([$product1, $product2]);

        $twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_products_carousel.html.twig',
            'products' => [$product1, $product2],
        ])->willReturn('rendered template');

        $this->render($contentConfiguration)->shouldReturn('rendered template');
    }
}
