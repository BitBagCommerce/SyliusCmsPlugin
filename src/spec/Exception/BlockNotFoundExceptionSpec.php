<?php

namespace spec\BitBag\CmsPlugin\Exception;

use BitBag\CmsPlugin\Exception\BlockNotFoundException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BlockNotFoundExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(BlockNotFoundException::class);
    }
}
