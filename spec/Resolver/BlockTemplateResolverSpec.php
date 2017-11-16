<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Resolver\BlockTemplateResolver;
use BitBag\SyliusCmsPlugin\Resolver\BlockTemplateResolverInterface;
use PhpSpec\ObjectBehavior;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockTemplateResolverSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(BlockTemplateResolver::class);
    }

    function it_implements_block_template_resolver_interface()
    {
        $this->shouldHaveType(BlockTemplateResolverInterface::class);
    }

    function it_returns_text_block_template(BlockInterface $block)
    {
        $block->getType()->willReturn('text');

        $this->resolveTemplate($block)->shouldReturn('@BitBagSyliusCmsPlugin/Shop/Block/Show/textBlock.html.twig');
    }

    function it_returns_html_block_template(BlockInterface $block)
    {
        $block->getType()->willReturn('html');

        $this->resolveTemplate($block)->shouldReturn('@BitBagSyliusCmsPlugin/Shop/Block/Show/htmlBlock.html.twig');
    }

    function it_returns_image_block_template(BlockInterface $block)
    {
        $block->getType()->willReturn('image');

        $this->resolveTemplate($block)->shouldReturn('@BitBagSyliusCmsPlugin/Shop/Block/Show/imageBlock.html.twig');
    }
}
