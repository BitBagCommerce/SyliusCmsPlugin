<?php

namespace spec\BitBag\CmsPlugin\Entity;

use BitBag\CmsPlugin\Entity\Block;
use BitBag\CmsPlugin\Entity\BlockInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;

final class BlockSpec extends ObjectBehavior
{
    const TYPE = 'Top Field';
    const CODE = 'xs';


    function it_is_initializable()
    {
        $this->shouldHaveType(Block::class);
        $this->shouldHaveType(BlockInterface::class);
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_allows_access_via_properties()
    {
        $this->setType(self::TYPE);
        $this->getType()->shouldReturn('Top Field');

        $this->setType(self::CODE);
        $this->getType()->shouldReturn('xs');
    }
}
