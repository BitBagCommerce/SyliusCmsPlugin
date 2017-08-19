<?php

namespace spec\BitBag\CmsPlugin\Exception;

use BitBag\CmsPlugin\Exception\TemplateNotFoundException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TemplateNotFoundExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TemplateNotFoundException::class);
    }
}
