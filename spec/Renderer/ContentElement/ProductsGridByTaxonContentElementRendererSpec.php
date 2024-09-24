<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer\ContentElement;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\ProductsGridByTaxonContentElementType;
use Sylius\CmsPlugin\Renderer\ContentElement\AbstractContentElement;
use Sylius\CmsPlugin\Renderer\ContentElement\ProductsGridByTaxonContentElementRenderer;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Twig\Environment;

final class ProductsGridByTaxonContentElementRendererSpec extends ObjectBehavior
{
    public function let(ProductRepositoryInterface $productRepository, TaxonRepositoryInterface $taxonRepository): void
    {
        $this->beConstructedWith($productRepository, $taxonRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductsGridByTaxonContentElementRenderer::class);
        $this->shouldBeAnInstanceOf(AbstractContentElement::class);
    }

    public function it_supports_products_grid_by_taxon_content_element_type(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn(ProductsGridByTaxonContentElementType::TYPE);
        $this->supports($contentConfiguration)->shouldReturn(true);
    }

    public function it_does_not_support_other_content_element_types(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn('other_type');
        $this->supports($contentConfiguration)->shouldReturn(false);
    }

    public function it_renders_products_grid_by_taxon_content_element(
        Environment $twig,
        ProductRepositoryInterface $productRepository,
        TaxonRepositoryInterface $taxonRepository,
        ContentConfigurationInterface $contentConfiguration,
        TaxonInterface $taxon,
        Product $product1,
        Product $product2,
    ): void {
        $template = 'custom_template';
        $this->setTemplate($template);
        $this->setTwigEnvironment($twig);

        $contentConfiguration->getConfiguration()->willReturn([
            'products_grid_by_taxon' => 'taxon_code',
        ]);

        $taxonRepository->findOneBy(['code' => 'taxon_code'])->willReturn($taxon);
        $productRepository->findByTaxon($taxon)->willReturn([$product1, $product2]);

        $twig->render('@SyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => $template,
            'products' => [$product1, $product2],
        ])->willReturn('rendered template');

        $this->render($contentConfiguration)->shouldReturn('rendered template');
    }
}
