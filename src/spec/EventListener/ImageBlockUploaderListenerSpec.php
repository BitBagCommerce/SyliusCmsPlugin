<?php

namespace spec\BitBag\CmsPlugin\EventListener;

use BitBag\CmsPlugin\EventListener\ImageBlockUploaderListener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImageBlockUploaderListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ImageBlockUploaderListener::class);
    }
}
