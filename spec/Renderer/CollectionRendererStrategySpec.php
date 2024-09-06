<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Renderer\Collection\CollectionRendererInterface;
use Sylius\CmsPlugin\Renderer\CollectionRendererStrategy;
use Sylius\CmsPlugin\Renderer\CollectionRendererStrategyInterface;

final class CollectionRendererStrategySpec extends ObjectBehavior
{
    public function let(CollectionRendererInterface $renderer1, CollectionRendererInterface $renderer2): void
    {
        $this->beConstructedWith([$renderer1, $renderer2]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CollectionRendererStrategy::class);
    }

    public function it_implements_collection_renderer_strategy_interface(): void
    {
        $this->shouldImplement(CollectionRendererStrategyInterface::class);
    }

    public function it_renders_collection_using_supported_renderer(
        CollectionRendererInterface $renderer1,
        CollectionRendererInterface $renderer2,
        CollectionInterface $collection,
    ): void {
        $renderer1->supports($collection)->willReturn(false);
        $renderer2->supports($collection)->willReturn(true);
        $renderer2->render($collection, null)->willReturn('rendered content');

        $this->render($collection)->shouldReturn('rendered content');
    }

    public function it_renders_collection_with_count_to_render(
        CollectionRendererInterface $renderer1,
        CollectionRendererInterface $renderer2,
        CollectionInterface $collection,
    ): void {
        $renderer1->supports($collection)->willReturn(false);
        $renderer2->supports($collection)->willReturn(true);
        $renderer2->render($collection, 5)->willReturn('rendered content with count');

        $this->render($collection, 5)->shouldReturn('rendered content with count');
    }

    public function it_returns_empty_string_when_no_renderer_supports_collection(
        CollectionRendererInterface $renderer1,
        CollectionRendererInterface $renderer2,
        CollectionInterface $collection,
    ): void {
        $renderer1->supports($collection)->willReturn(false);
        $renderer2->supports($collection)->willReturn(false);

        $this->render($collection)->shouldReturn('');
    }
}
