<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer\ContentElement;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\ProductsCarouselContentElementType;
use Sylius\CmsPlugin\Renderer\ContentElement\AbstractContentElement;
use Sylius\CmsPlugin\Renderer\ContentElement\ProductsCarouselContentElementRenderer;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Twig\Environment;

final class ProductsCarouselContentElementRendererSpec extends ObjectBehavior
{
    public function let(ProductRepositoryInterface $productRepository): void
    {
        $this->beConstructedWith($productRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductsCarouselContentElementRenderer::class);
        $this->shouldBeAnInstanceOf(AbstractContentElement::class);
    }

    public function it_supports_products_carousel_content_element_type(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn(ProductsCarouselContentElementType::TYPE);
        $this->supports($contentConfiguration)->shouldReturn(true);
    }

    public function it_does_not_support_other_content_element_types(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn('other_type');
        $this->supports($contentConfiguration)->shouldReturn(false);
    }

    public function it_renders_products_carousel_content_element(
        Environment $twig,
        ProductRepositoryInterface $productRepository,
        ContentConfigurationInterface $contentConfiguration,
        Product $product1,
        Product $product2,
    ): void {
        $template = 'custom_template';
        $this->setTemplate($template);
        $this->setTwigEnvironment($twig);

        $contentConfiguration->getConfiguration()->willReturn([
            'products_carousel' => ['products' => ['code1', 'code2']],
        ]);

        $productRepository->findBy(['code' => ['code1', 'code2']])->willReturn([$product1, $product2]);

        $twig->render('@SyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => $template,
            'products' => [$product1, $product2],
        ])->willReturn('rendered template');

        $this->render($contentConfiguration)->shouldReturn('rendered template');
    }
}
