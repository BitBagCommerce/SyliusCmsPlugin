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

use BitBag\SyliusCmsPlugin\DataCollector\BlockRenderingEventRecorderInterface;
use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\BlockResourceResolverInterface;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderBlockRuntime;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderBlockRuntimeInterface;
use PhpSpec\ObjectBehavior;
use Twig\Environment;

final class RenderBlockRuntimeSpec extends ObjectBehavior
{
    public function let(
        BlockRepositoryInterface $blockRepository,
        BlockResourceResolverInterface $blockResourceResolver,
        Environment $templatingEngine,
        BlockRenderingEventRecorderInterface $blockRenderingEventRecorder
    ): void {
        $this->beConstructedWith($blockRepository, $blockResourceResolver, $templatingEngine, $blockRenderingEventRecorder);
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
        BlockRenderingEventRecorderInterface $blockRenderingEventRecorder
    ): void {
        $blockResourceResolver->findOrLog('bitbag')->willReturn($block);

        $blockRenderingEventRecorder->recordRenderingBlock($block);

        $templatingEngine->render('@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig', ['block' => $block])->willReturn('<div>BitBag</div>');

        $this->renderBlock('bitbag');
    }

    public function it_renders_block_with_template(
        BlockResourceResolverInterface $blockResourceResolver,
        BlockInterface $block,
        Environment $templatingEngine,
        BlockRenderingEventRecorderInterface $blockRenderingEventRecorder
    ): void {
        $blockResourceResolver->findOrLog('bitbag')->willReturn($block);

        $blockRenderingEventRecorder->recordRenderingBlock($block);

        $templatingEngine->render('@BitBagSyliusCmsPlugin/Shop/Block/otherTemplate.html.twig', ['block' => $block])->willReturn('<div>BitBag Other Template</div>');

        $this->renderBlock('bitbag', '@BitBagSyliusCmsPlugin/Shop/Block/otherTemplate.html.twig');
    }
}
