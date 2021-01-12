<?php

namespace spec\BitBag\SyliusCmsPlugin\Twig\Parser;

use BitBag\SyliusCmsPlugin\Twig\Parser\ContentParser;
use BitBag\SyliusCmsPlugin\Twig\Parser\ContentParserInterface;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderBlockRuntimeInterface;
use PhpSpec\ObjectBehavior;
use Twig\Environment;
use Twig\TwigFunction;

final class ContentParserSpec extends ObjectBehavior
{
    function let(Environment $twigEnvironment): void
    {
        $this->beConstructedWith($twigEnvironment, ['bitbag_cms_render_block']);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ContentParser::class);
    }

    function it_implements_content_parser_interface(): void
    {
        $this->shouldHaveType(ContentParserInterface::class);
    }

    function it_parses_string_functions(
        Environment $twigEnvironment,
        TwigFunction $renderBlockFunction,
        RenderBlockRuntimeInterface $renderBlockRuntime
    ): void
    {
        $twigEnvironment->getFunctions()->willReturn([
            'bitbag_cms_render_block' => $renderBlockFunction,
        ]);
        $renderBlockFunction->getCallable()->willReturn([$renderBlockRuntime, 'renderBlock']);

        $input = "Let's render! {{ bitbag_cms_render_block('intro', '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig') }}";

        $renderBlockRuntime->renderBlock('intro', '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig')->shouldBeCalled();

        $this->parse($input);
    }
}
