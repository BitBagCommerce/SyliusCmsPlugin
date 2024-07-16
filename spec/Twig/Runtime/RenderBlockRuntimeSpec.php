<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Twig\Runtime;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Renderer\ContentElementRendererStrategyInterface;
use BitBag\SyliusCmsPlugin\Resolver\BlockResourceResolverInterface;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderBlockRuntime;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderBlockRuntimeInterface;
use PhpSpec\ObjectBehavior;
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
        $this->shouldHaveType(RenderBlockRuntimeInterface::class);
    }

    public function it_renders_block(
        BlockResourceResolverInterface $blockResourceResolver,
        BlockInterface $block,
        Environment $templatingEngine,
        ContentElementRendererStrategyInterface $contentElementRendererStrategy,
    ): void {
        $blockResourceResolver->findOrLog('bitbag')->willReturn($block);
        $contentElementRendererStrategy->render($block)->willReturn('rendered content');
        $templatingEngine->render(
            '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig',
            ['content' => 'rendered content'],
        )->willReturn('<div>BitBag</div>');

        $this->renderBlock('bitbag');
    }

    public function it_renders_block_with_template(
        BlockResourceResolverInterface $blockResourceResolver,
        BlockInterface $block,
        Environment $templatingEngine,
        ContentElementRendererStrategyInterface $contentElementRendererStrategy,
    ): void {
        $blockResourceResolver->findOrLog('bitbag')->willReturn($block);
        $contentElementRendererStrategy->render($block)->willReturn('rendered content');
        $templatingEngine->render(
            '@BitBagSyliusCmsPlugin/Shop/Block/otherTemplate.html.twig',
            ['content' => 'rendered content'],
        )->willReturn('<div>BitBag Other Template</div>');

        $this->renderBlock('bitbag', '@BitBagSyliusCmsPlugin/Shop/Block/otherTemplate.html.twig');
    }
}
