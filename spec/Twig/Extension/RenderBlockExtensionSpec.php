<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\CmsPlugin\Twig\Extension;

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use BitBag\CmsPlugin\Twig\Extension\RenderBlockExtension;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class RenderBlockExtensionSpec extends ObjectBehavior
{
    function let(
        BlockRepositoryInterface $blockRepository,
        LoggerInterface $logger
    ): void
    {
        $this->beConstructedWith($blockRepository, $logger);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderBlockExtension::class);
    }

    function it_extends_twig_extension(): void
    {
        $this->shouldHaveType(\Twig_Extension::class);
    }

    function it_returns_functions(): void
    {
        $functions = $this->getFunctions();
        $functions->shouldHaveCount(1);

        foreach ($functions as $function) {
            $function->shouldHaveType(\Twig_SimpleFunction::class);
        }
    }

    function it_adds_warning_for_not_found_block(
        BlockRepositoryInterface $blockRepository,
        LoggerInterface $logger,
        \Twig_Environment $twigEnvironment
    ): void
    {
        $blockRepository->findEnabledByCode('bitbag')->willReturn(null);
        $logger->warning('Block with "bitbag" code was not found in the database.')->shouldBeCalled();

        $this->renderBlock($twigEnvironment, 'bitbag')->shouldReturn(null);
    }

    function it_renders_text_template_for_text_type(
        BlockRepositoryInterface $blockRepository,
        BlockInterface $block,
        \Twig_Environment $twigEnvironment
    ): void
    {
        $blockRepository->findEnabledByCode('bitbag')->willReturn($block);
        $block->getType()->willReturn('text');
        $twigEnvironment->render('@BitBagCmsPlugin/Shop/Block/textBlock.html.twig', ['block' => $block])->shouldBeCalled();

        $this->renderBlock($twigEnvironment, 'bitbag');
    }

    function it_renders_html_template_for_html_type(
        BlockRepositoryInterface $blockRepository,
        BlockInterface $block,
        \Twig_Environment $twigEnvironment
    ): void
    {
        $blockRepository->findEnabledByCode('bitbag')->willReturn($block);
        $block->getType()->willReturn('html');
        $twigEnvironment->render('@BitBagCmsPlugin/Shop/Block/htmlBlock.html.twig', ['block' => $block])->shouldBeCalled();

        $this->renderBlock($twigEnvironment, 'bitbag');
    }

    function it_renders_image_template_for_image_type(
        BlockRepositoryInterface $blockRepository,
        BlockInterface $block,
        \Twig_Environment $twigEnvironment
    ): void
    {
        $blockRepository->findEnabledByCode('bitbag')->willReturn($block);
        $block->getType()->willReturn('image');
        $twigEnvironment->render('@BitBagCmsPlugin/Shop/Block/imageBlock.html.twig', ['block' => $block])->shouldBeCalled();

        $this->renderBlock($twigEnvironment, 'bitbag');
    }
}
