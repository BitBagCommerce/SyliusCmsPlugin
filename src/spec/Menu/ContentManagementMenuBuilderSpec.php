<?php

namespace spec\BitBag\CmsPlugin\Menu;

use BitBag\CmsPlugin\Menu\ContentManagementMenuBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContentManagementMenuBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ContentManagementMenuBuilder::class);
    }
}
