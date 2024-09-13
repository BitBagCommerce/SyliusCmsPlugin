<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer;

use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Renderer\ContentElement\ContentElementRendererInterface;
use Sylius\CmsPlugin\Renderer\ContentElementRendererStrategyInterface;
use Sylius\CmsPlugin\Twig\Parser\ContentParserInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class ContentElementRendererStrategySpec extends ObjectBehavior
{
    public function let(
        ContentParserInterface $contentParser,
        LocaleContextInterface $localeContext,
        ContentElementRendererInterface $renderer
    ): void {
        $this->beConstructedWith($contentParser, $localeContext, [$renderer]);
    }

    public function it_implements_content_element_renderer_strategy_interface(): void
    {
        $this->shouldImplement(ContentElementRendererStrategyInterface::class);
    }

    public function it_renders_a_page_content_element_correctly(
        PageInterface $page,
        ContentConfigurationInterface $contentElement,
        LocaleContextInterface $localeContext,
        ContentElementRendererInterface $renderer,
        ContentParserInterface $contentParser
    ): void {
        $page->getContentElements()->willReturn(new ArrayCollection([$contentElement->getWrappedObject()]));
        $localeContext->getLocaleCode()->willReturn('en_US');
        $contentElement->getLocale()->willReturn('en_US');

        $renderer->supports($contentElement)->willReturn(true);
        $renderer->render($contentElement)->willReturn('&lt;p&gt;Hello World&lt;/p&gt;');

        $contentParser->parse('<p>Hello World</p>')->willReturn('<p>Hello World</p>');

        $this->render($page)->shouldReturn('<p>Hello World</p>');
    }

    public function it_skips_content_element_with_non_matching_locale(
        BlockInterface $block,
        ContentConfigurationInterface $contentElement,
        LocaleContextInterface $localeContext,
        ContentParserInterface $contentParser
    ): void {
        $block->getContentElements()->willReturn(new ArrayCollection([$contentElement]));
        $localeContext->getLocaleCode()->willReturn('en_US');
        $contentElement->getLocale()->willReturn('fr_FR');

        $contentParser->parse('')->willReturn('');

        $this->render($block)->shouldReturn('');
    }

    public function it_renders_only_supported_content_elements(
        BlockInterface $block,
        ContentConfigurationInterface $supportedElement,
        ContentConfigurationInterface $unsupportedElement,
        LocaleContextInterface $localeContext,
        ContentElementRendererInterface $renderer,
        ContentParserInterface $contentParser
    ): void {
        $block->getContentElements()->willReturn(new ArrayCollection([$supportedElement->getWrappedObject(), $unsupportedElement->getWrappedObject()]));
        $localeContext->getLocaleCode()->willReturn('en_US');
        $supportedElement->getLocale()->willReturn('en_US');
        $unsupportedElement->getLocale()->willReturn('en_US');

        $renderer->supports($supportedElement)->willReturn(true);
        $renderer->render($supportedElement)->willReturn('&lt;p&gt;Supported&lt;/p&gt;');
        $renderer->supports($unsupportedElement)->willReturn(false);

        $contentParser->parse('<p>Supported</p>')->willReturn('<p>Supported</p>');

        $this->render($block)->shouldReturn('<p>Supported</p>');
    }
}
