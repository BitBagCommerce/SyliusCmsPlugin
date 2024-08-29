<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer\ContentElement;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\ProductsGridContentElementType;
use Sylius\CmsPlugin\Renderer\ContentElement\ContentElementRendererInterface;
use Sylius\CmsPlugin\Renderer\ContentElement\ProductsGridContentElementRenderer;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Twig\Environment;

final class ProductsGridContentElementRendererSpec extends ObjectBehavior
{
    public function let(Environment $twig, ProductRepositoryInterface $productRepository): void
    {
        $this->beConstructedWith($twig, $productRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductsGridContentElementRenderer::class);
    }

    public function it_implements_content_element_renderer_interface(): void
    {
        $this->shouldImplement(ContentElementRendererInterface::class);
    }

    public function it_supports_products_grid_content_element_type(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn(ProductsGridContentElementType::TYPE);
        $this->supports($contentConfiguration)->shouldReturn(true);
    }

    public function it_does_not_support_other_content_element_types(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn('other_type');
        $this->supports($contentConfiguration)->shouldReturn(false);
    }

    public function it_renders_products_grid_content_element(
        Environment $twig,
        ProductRepositoryInterface $productRepository,
        ContentConfigurationInterface $contentConfiguration,
        Product $product1,
        Product $product2,
    ): void {
        $contentConfiguration->getConfiguration()->willReturn([
            'products_grid' => ['products' => ['code1', 'code2']],
        ]);

        $productRepository->findBy(['code' => ['code1', 'code2']])->willReturn([$product1, $product2]);

        $twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_products_grid.html.twig',
            'products' => [$product1, $product2],
        ])->willReturn('rendered template');

        $this->render($contentConfiguration)->shouldReturn('rendered template');
    }
}
