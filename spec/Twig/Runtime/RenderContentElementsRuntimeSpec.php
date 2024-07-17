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
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Renderer\ContentElementRendererStrategyInterface;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderContentElementsRuntime;
use PhpSpec\ObjectBehavior;

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