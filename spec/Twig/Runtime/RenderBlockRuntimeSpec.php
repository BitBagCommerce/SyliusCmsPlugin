<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Twig\Runtime;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Renderer\ContentElementRendererStrategyInterface;
use Sylius\CmsPlugin\Resolver\BlockResourceResolverInterface;
use Sylius\CmsPlugin\Twig\Runtime\RenderBlockRuntime;
use Sylius\CmsPlugin\Twig\Runtime\RenderBlockRuntimeInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Twig\Environment;

final class RenderBlockRuntimeSpec extends ObjectBehavior
{
    public function let(
        BlockResourceResolverInterface $blockResourceResolver,
        Environment $templatingEngine,
        ContentElementRendererStrategyInterface $contentElementRendererStrategy,
    ): void {
        $this->beConstructedWith($blockResourceResolver, $templatingEngine, $contentElementRendererStrategy);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderBlockRuntime::class);
    }

    public function it_implements_render_block_runtime_interface(): void
    {
        $this->shouldImplement(RenderBlockRuntimeInterface::class);
    }

    public function it_returns_empty_string_when_block_not_found(BlockResourceResolverInterface $blockResourceResolver): void
    {
        $blockResourceResolver->findOrLog('code')->willReturn(null);

        $this->renderBlock('code')->shouldReturn('');
    }

    public function it_returns_empty_string_when_block_not_displayable_for_taxon(
        BlockResourceResolverInterface $blockResourceResolver,
        BlockInterface $block,
        TaxonInterface $taxon,
    ): void {
        $blockResourceResolver->findOrLog('code')->willReturn($block);
        $block->canBeDisplayedForTaxon($taxon)->willReturn(false);

        $this->renderBlock('code', null, $taxon)->shouldReturn('');
    }

    public function it_returns_empty_string_when_block_not_displayable_for_product(
        BlockResourceResolverInterface $blockResourceResolver,
        BlockInterface $block,
        ProductInterface $product,
    ): void {
        $blockResourceResolver->findOrLog('code')->willReturn($block);
        $block->canBeDisplayedForProduct($product)->willReturn(false);
        $block->canBeDisplayedForProductInTaxon($product)->willReturn(false);

        $this->renderBlock('code', null, $product)->shouldReturn('');
    }

    public function it_renders_block_with_default_template(
        BlockResourceResolverInterface $blockResourceResolver,
        Environment $templatingEngine,
        ContentElementRendererStrategyInterface $contentElementRendererStrategy,
        BlockInterface $block,
    ): void {
        $blockResourceResolver->findOrLog('code')->willReturn($block);
        $contentElementRendererStrategy->render($block)->willReturn('rendered content');

        $templatingEngine->render('@SyliusCmsPlugin/Shop/Block/show.html.twig', [
            'content' => 'rendered content',
            'context' => null,
        ])->willReturn('rendered block');

        $this->renderBlock('code')->shouldReturn('rendered block');
    }

    public function it_renders_block_with_custom_template(
        BlockResourceResolverInterface $blockResourceResolver,
        Environment $templatingEngine,
        ContentElementRendererStrategyInterface $contentElementRendererStrategy,
        BlockInterface $block,
    ): void {
        $blockResourceResolver->findOrLog('code')->willReturn($block);
        $contentElementRendererStrategy->render($block)->willReturn('rendered content');

        $templatingEngine->render('custom_template.html.twig', [
            'content' => 'rendered content',
            'context' => null,
        ])->willReturn('rendered block');

        $this->renderBlock('code', 'custom_template.html.twig')->shouldReturn('rendered block');
    }
}
