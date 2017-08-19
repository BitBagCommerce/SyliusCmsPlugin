<?php

namespace spec\BitBag\CmsPlugin\Entity;

use BitBag\CmsPlugin\Entity\Block;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BlockSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Block::class);
    }
}
