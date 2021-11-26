<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Twig\Extension\RenderProductPagesExtension;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderBlockRuntimeInterface;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderProductPagesRuntime;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderProductPagesRuntimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;

final class RenderProductPagesExtensionSpec extends ObjectBehavior
{
    function let(
        RenderProductPagesRuntimeInterface $productPagesRuntime
    ): void {
        $this->beConstructedWith($productPagesRuntime);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderProductPagesExtension::class);
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
            $function->shouldHaveType(\Twig_SimpleFunction::class);
        }
    }
}
