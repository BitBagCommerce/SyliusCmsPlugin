<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Twig\Runtime;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Renderer\ContentElementRendererStrategyInterface;
use Sylius\CmsPlugin\Twig\Runtime\RenderContentElementsRuntime;

final class RenderContentElementsRuntimeSpec extends ObjectBehavior
{
    public function let(ContentElementRendererStrategyInterface $contentElementRendererStrategy): void
    {
        $this->beConstructedWith($contentElementRendererStrategy);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderContentElementsRuntime::class);
    }

    public function it_renders_a_block(ContentElementRendererStrategyInterface $contentElementRendererStrategy, BlockInterface $block): void
    {
        $contentElementRendererStrategy->render($block)->willReturn('rendered block content');
        $this->render($block)->shouldReturn('rendered block content');
    }

    public function it_renders_a_page(ContentElementRendererStrategyInterface $contentElementRendererStrategy, PageInterface $page): void
    {
        $contentElementRendererStrategy->render($page)->willReturn('rendered page content');
        $this->render($page)->shouldReturn('rendered page content');
    }
}
