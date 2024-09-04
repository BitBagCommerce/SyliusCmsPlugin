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

use BitBag\SyliusCmsPlugin\Entity\ContentableInterface;
use BitBag\SyliusCmsPlugin\Twig\Parser\ContentParserInterface;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderContentRuntime;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderContentRuntimeInterface;
use PhpSpec\ObjectBehavior;

final class RenderContentRuntimeSpec extends ObjectBehavior
{
    public function let(
        ContentParserInterface $contentParser,
    ): void {
        $this->beConstructedWith($contentParser);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderContentRuntime::class);
    }

    public function it_implements_render_content_runtime_interface(): void
    {
        $this->shouldHaveType(RenderContentRuntimeInterface::class);
    }

    public function it_renders_content(
        ContentParserInterface $contentParser,
        ContentableInterface $contentableResource,
    ): void {
        $contentParser->parse('content')->willReturn('content');
        $contentableResource->getContent()->willReturn('content');

        $this->renderContent($contentableResource)->shouldReturn('content');
    }
}
