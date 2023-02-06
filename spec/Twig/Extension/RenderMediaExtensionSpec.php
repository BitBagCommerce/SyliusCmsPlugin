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

use BitBag\SyliusCmsPlugin\Twig\Extension\RenderMediaExtension;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderMediaRuntimeInterface;
use PhpSpec\ObjectBehavior;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RenderMediaExtensionSpec extends ObjectBehavior
{
    function let(
        RenderMediaRuntimeInterface $mediaRuntime
    ) {
        $this->beConstructedWith($mediaRuntime);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderMediaExtension::class);
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
