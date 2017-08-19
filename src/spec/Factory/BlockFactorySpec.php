<?php

namespace spec\BitBag\CmsPlugin\Factory;

use BitBag\CmsPlugin\Factory\BlockFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BlockFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(BlockFactory::class);
    }
}
