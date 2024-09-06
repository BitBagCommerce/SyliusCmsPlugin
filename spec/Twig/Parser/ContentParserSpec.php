<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Twig\Parser;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Twig\Parser\ContentParser;
use Sylius\CmsPlugin\Twig\Parser\ContentParserInterface;
use Sylius\CmsPlugin\Twig\Runtime\RenderBlockRuntimeInterface;
use Twig\Environment;
use Twig\TwigFunction;

final class ContentParserSpec extends ObjectBehavior
{
    public function let(Environment $twigEnvironment): void
    {
        $this->beConstructedWith($twigEnvironment, ['sylius_cms_render_block']);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ContentParser::class);
    }

    public function it_implements_content_parser_interface(): void
    {
        $this->shouldHaveType(ContentParserInterface::class);
    }

    public function it_parses_string_function(
        Environment $twigEnvironment,
        RenderBlockRuntimeInterface $renderBlockRuntime,
    ): void {
        $twigFunctionName = 'sylius_cms_render_block';
        $twigEnvironment->getFunctions()->willReturn([
            $twigFunctionName => new TwigFunction($twigFunctionName, [$renderBlockRuntime->getWrappedObject(), 'renderBlock']),
        ]);

        $input = "Let's render! {{ sylius_cms_render_block('intro', '@SyliusCmsPlugin/Shop/Block/show.html.twig') }}";

        $renderBlockRuntime->renderBlock('intro', '@SyliusCmsPlugin/Shop/Block/show.html.twig')->shouldBeCalled();

        $this->parse($input);
    }

    public function it_parses_string_functions(
        Environment $twigEnvironment,
        RenderBlockRuntimeInterface $renderBlockRuntime,
    ): void {
        $twigFunctionName = 'sylius_cms_render_block';
        $twigEnvironment->getFunctions()->willReturn([
            $twigFunctionName => new TwigFunction($twigFunctionName, [$renderBlockRuntime->getWrappedObject(), 'renderBlock']),
        ]);

        $input = "Let's render! {{ sylius_cms_render_block('intro', '@SyliusCmsPlugin/Shop/Block/show.html.twig') }}
                  Let's render twice! {{ sylius_cms_render_block('intro1', '@SyliusCmsPlugin/Shop/Block/show.html.twig') }}";

        $renderBlockRuntime->renderBlock('intro', '@SyliusCmsPlugin/Shop/Block/show.html.twig')->shouldBeCalled();
        $renderBlockRuntime->renderBlock('intro1', '@SyliusCmsPlugin/Shop/Block/show.html.twig')->shouldBeCalled();

        $this->parse($input);
    }
}
