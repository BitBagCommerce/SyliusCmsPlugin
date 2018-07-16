<?php

namespace spec\BitBag\SyliusCmsPlugin\Twig\Parser;

use BitBag\SyliusCmsPlugin\Twig\Extension\RenderBlockExtension;
use BitBag\SyliusCmsPlugin\Twig\Parser\ContentParser;
use BitBag\SyliusCmsPlugin\Twig\Parser\ContentParserInterface;
use PhpSpec\ObjectBehavior;

final class ContentParserSpec extends ObjectBehavior
{
    function let(\Twig_Environment $twigEnvironment): void
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
        \Twig_Environment $twigEnvironment,
        \Twig_Function $renderBlockFunction,
        RenderBlockExtension $renderBlockExtension
    ): void
    {
        $twigEnvironment->getFunctions()->willReturn([
            'bitbag_cms_render_block' => $renderBlockFunction,
        ]);
        $renderBlockFunction->getCallable()->willReturn([$renderBlockExtension, 'renderBlock']);

        $input = "Let's render! {{ bitbag_cms_render_block('intro', '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig') }}";

        $renderBlockExtension->renderBlock('intro', '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig')->shouldBeCalled();

        $this->parse($input);
    }
}
