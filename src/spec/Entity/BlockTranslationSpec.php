<?php

namespace spec\BitBag\CmsPlugin\Entity;

use BitBag\CmsPlugin\Entity\BlockTranslation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BlockTranslationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(BlockTranslation::class);
    }
}
