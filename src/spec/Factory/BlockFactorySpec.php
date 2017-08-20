<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\CmsPlugin\Factory;

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Factory\BlockFactory;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockFactorySpec extends ObjectBehavior
{
    function let(FactoryInterface $resourceFactory)
    {
        $this->beConstructedWith($resourceFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BlockFactory::class);
    }

    function it_creates_new_block(
        FactoryInterface $resourceFactory,
        BlockInterface $block
    )
    {
        $resourceFactory->createNew()->willReturn($block);

        $this->createNew()->shouldBeEqualTo($block);
    }

    function it_creates_new_block_with_type(
        FactoryInterface $resourceFactory,
        BlockInterface $block
    )
    {
        $resourceFactory->createNew()->willReturn($block);
        $block->setType('image')->shouldBeCalled();

        $this->createWithType('image')->shouldBeEqualTo($block);
    }
}
