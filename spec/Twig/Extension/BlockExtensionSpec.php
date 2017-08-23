<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\CmsPlugin\Twig\Extension;

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use BitBag\CmsPlugin\Twig\Extension\BlockExtension;
use PhpSpec\ObjectBehavior;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockExtensionSpec extends ObjectBehavior
{
    function let(BlockRepositoryInterface $blockRepository)
    {
        $this->beConstructedWith($blockRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BlockExtension::class);
    }

    function it_extends_twig_extension()
    {
        $this->shouldHaveType(\Twig_Extension::class);
    }

    function it_returns_functions()
    {
        $functions = $this->getFunctions();
        $functions->shouldHaveCount(2);

        foreach ($functions as $function) {
            $function->shouldHaveType(\Twig_SimpleFunction::class);
        }
    }

    function it_returns_block_for_block_function(
        BlockRepositoryInterface $blockRepository,
        BlockInterface $block
    )
    {
        $blockRepository->findOneByCode('bitbag')->willReturn($block);

        $this->block('bitbag')->shouldBeEqualTo($block);
    }

    function it_renders_text_template_for_text_type(
        BlockRepositoryInterface $blockRepository,
        BlockInterface $block,
        \Twig_Environment $twigEnvironment
    )
    {
        $blockRepository->findOneByCode('bitbag')->willReturn($block);
        $block->getType()->willReturn('text');
        $twigEnvironment->render('BitBagCmsPlugin:Block:textBlock.html.twig', ['block' => $block])->shouldBeCalled();

        $this->renderBlock($twigEnvironment, 'bitbag');
    }

    function it_renders_image_template_for_image_type(
        BlockRepositoryInterface $blockRepository,
        BlockInterface $block,
        \Twig_Environment $twigEnvironment
    )
    {
        $blockRepository->findOneByCode('bitbag')->willReturn($block);
        $block->getType()->willReturn('image');
        $twigEnvironment->render('BitBagCmsPlugin:Block:imageBlock.html.twig', ['block' => $block])->shouldBeCalled();

        $this->renderBlock($twigEnvironment, 'bitbag');
    }
}
