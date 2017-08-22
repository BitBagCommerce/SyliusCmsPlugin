<?php

namespace spec\BitBag\CmsPlugin\Entity;

use BitBag\CmsPlugin\Entity\ImageBlock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImageBlockSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ImageBlock::class);
    }
}
