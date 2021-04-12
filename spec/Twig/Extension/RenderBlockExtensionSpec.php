<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Twig\Extension\RenderBlockExtension;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderBlockRuntimeInterface;
use PhpSpec\ObjectBehavior;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RenderBlockExtensionSpec extends ObjectBehavior
{
    function let(
        RenderBlockRuntimeInterface $blockRuntime
    ) {
        $this->beConstructedWith($blockRuntime);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderBlockExtension::class);
    }

    function it_extends_abstract_extension(): void
    {
        $this->shouldHaveType(AbstractExtension::class);
    }

    function it_returns_functions(): void
    {
        $functions = $this->getFunctions();

        $functions->shouldHaveCount(1);

        foreach ($functions as $function) {
            $function->shouldHaveType(TwigFunction::class);
        }
    }
}
