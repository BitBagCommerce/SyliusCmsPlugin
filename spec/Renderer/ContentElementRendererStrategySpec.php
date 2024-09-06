<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer;

use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Renderer\ContentElement\ContentElementRendererInterface;
use Sylius\CmsPlugin\Renderer\ContentElementRendererStrategy;
use Sylius\CmsPlugin\Renderer\ContentElementRendererStrategyInterface;
use Sylius\CmsPlugin\Twig\Parser\ContentParserInterface;

final class ContentElementRendererStrategySpec extends ObjectBehavior
{
    public function let(
        ContentParserInterface $contentParser,
        ContentElementRendererInterface $renderer1,
        ContentElementRendererInterface $renderer2,
    ): void {
        $this->beConstructedWith($contentParser, [$renderer1, $renderer2]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ContentElementRendererStrategy::class);
    }

    public function it_implements_content_element_renderer_strategy_interface(): void
    {
        $this->shouldImplement(ContentElementRendererStrategyInterface::class);
    }

    public function it_renders_content_elements_using_registered_renderers(
        ContentParserInterface $contentParser,
        ContentElementRendererInterface $renderer1,
        ContentElementRendererInterface $renderer2,
        BlockInterface $block,
        ContentConfigurationInterface $contentElement1,
        ContentConfigurationInterface $contentElement2,
    ): void {
        $block->getContentElements()->willReturn(
            new ArrayCollection([$contentElement1->getWrappedObject(), $contentElement2->getWrappedObject()]),
        );

        $renderer1->supports($contentElement1)->willReturn(true);
        $renderer1->supports($contentElement2)->willReturn(false);
        $renderer1->render($contentElement1)->willReturn('Rendered content 1');
        $renderer2->supports($contentElement2)->willReturn(true);
        $renderer2->supports($contentElement1)->willReturn(false);
        $renderer2->render($contentElement2)->willReturn('Rendered content 2');

        $expectedParsedContent = 'Parsed content after rendering';

        $contentParser->parse('Rendered content 1Rendered content 2')->willReturn($expectedParsedContent);

        $this->render($block)->shouldReturn($expectedParsedContent);
    }

    public function it_renders_content_elements_using_registered_renderers_for_page(
        ContentParserInterface $contentParser,
        ContentElementRendererInterface $renderer1,
        ContentElementRendererInterface $renderer2,
        PageInterface $page,
        ContentConfigurationInterface $contentElement1,
        ContentConfigurationInterface $contentElement2,
    ): void {
        $page->getContentElements()->willReturn(
            new ArrayCollection([$contentElement1->getWrappedObject(), $contentElement2->getWrappedObject()]),
        );

        $renderer1->supports($contentElement1)->willReturn(true);
        $renderer1->supports($contentElement2)->willReturn(false);
        $renderer1->render($contentElement1)->willReturn('Rendered content 1');
        $renderer2->supports($contentElement2)->willReturn(true);
        $renderer2->supports($contentElement1)->willReturn(false);
        $renderer2->render($contentElement2)->willReturn('Rendered content 2');

        $expectedParsedContent = 'Parsed content after rendering';

        $contentParser->parse('Rendered content 1Rendered content 2')->willReturn($expectedParsedContent);

        $this->render($page)->shouldReturn($expectedParsedContent);
    }
}
