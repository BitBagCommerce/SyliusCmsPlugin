<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\CmsPlugin\Entity;

use BitBag\CmsPlugin\Entity\Block;
use BitBag\CmsPlugin\Entity\BlockInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockSpec extends ObjectBehavior
{
    const TYPE = 'image';
    const CODE = 'new_focus_rs';

    function it_is_initializable()
    {
        $this->shouldHaveType(Block::class);
    }

    function it_is_a_resource()
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_implements_block_interface()
    {
        $this->shouldHaveType(BlockInterface::class);
    }

    function it_allows_access_via_properties()
    {
        $this->setType(self::TYPE);
        $this->getType()->shouldReturn('image');

        $this->setType(self::CODE);
        $this->getType()->shouldReturn('new_focus_rs');

        $this->setEnabled(true);
        $this->isEnabled()->shouldReturn(true);
    }

    function it_toggles()
    {
        $this->enable();
        $this->isEnabled()->shouldReturn(true);

        $this->disable();
        $this->isEnabled()->shouldReturn(false);
    }
}
