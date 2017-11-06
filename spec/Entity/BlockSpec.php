<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

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
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Block::class);
    }

    function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_implements_block_interface(): void
    {
        $this->shouldHaveType(BlockInterface::class);
    }

    function it_allows_access_via_properties(): void
    {
        $this->setType('image');
        $this->getType()->shouldReturn('image');

        $this->setType('new_focus_rs');
        $this->getType()->shouldReturn('new_focus_rs');

        $this->setEnabled(true);
        $this->isEnabled()->shouldReturn(true);
    }

    function it_toggles(): void
    {
        $this->enable();
        $this->isEnabled()->shouldReturn(true);

        $this->disable();
        $this->isEnabled()->shouldReturn(false);
    }
}
