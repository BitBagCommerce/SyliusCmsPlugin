<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Twig\Parser;

use BitBag\SyliusCmsPlugin\Twig\Parser\ContentParser;
use BitBag\SyliusCmsPlugin\Twig\Parser\ContentParserInterface;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderBlockRuntimeInterface;
use PhpSpec\ObjectBehavior;
use Twig\Environment;
use Twig\TwigFunction;

final class ContentParserSpec extends ObjectBehavior
{
    public function let(Environment $twigEnvironment): void
    {
        $this->beConstructedWith($twigEnvironment, ['bitbag_cms_render_block']);
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
        RenderBlockRuntimeInterface $renderBlockRuntime
    ): void {
        $twigFunctionName = 'bitbag_cms_render_block';
        $twigEnvironment->getFunctions()->willReturn([
            $twigFunctionName => new TwigFunction($twigFunctionName, [$renderBlockRuntime->getWrappedObject(), 'renderBlock'])
        ]);

        $input = "Let's render! {{ bitbag_cms_render_block('intro', '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig') }}";

        $renderBlockRuntime->renderBlock('intro', '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig')->shouldBeCalled();

        $this->parse($input);
    }

    public function it_parses_string_functions(
        Environment $twigEnvironment,
        RenderBlockRuntimeInterface $renderBlockRuntime
    ): void {

        $twigFunctionName = 'bitbag_cms_render_block';
        $twigEnvironment->getFunctions()->willReturn([
            $twigFunctionName => new TwigFunction($twigFunctionName, [$renderBlockRuntime->getWrappedObject(), 'renderBlock'])
        ]);

        $input = "Let's render! {{ bitbag_cms_render_block('intro', '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig') }}
                  Let's render twice! {{ bitbag_cms_render_block('intro1', '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig') }}";

        $renderBlockRuntime->renderBlock('intro', '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig')->shouldBeCalled();
        $renderBlockRuntime->renderBlock('intro1', '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig')->shouldBeCalled();

        $this->parse($input);
    }
}
