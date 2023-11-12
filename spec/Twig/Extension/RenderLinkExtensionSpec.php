<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Twig\Extension\RenderLinkExtension;
use PhpSpec\ObjectBehavior;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RenderLinkExtensionSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderLinkExtension::class);
    }

    public function it_extends_abstract_extension(): void
    {
        $this->shouldHaveType(AbstractExtension::class);
    }

    public function it_returns_functions(): void
    {
        $functions = $this->getFunctions();

        $functions->shouldHaveCount(2);

        foreach ($functions as $function) {
            $function->shouldHaveType(TwigFunction::class);
        }
    }
}
