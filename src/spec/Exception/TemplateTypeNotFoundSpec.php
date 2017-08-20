<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\CmsPlugin\Exception;

use BitBag\CmsPlugin\Exception\TemplateTypeNotFound;
use PhpSpec\ObjectBehavior;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class TemplateTypeNotFoundSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('bitbag');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TemplateTypeNotFound::class);
    }

    function it_is_an_exception()
    {
        $this->shouldHaveType(\Exception::class);
    }

    function it_has_custom_message()
    {
        $this->getMessage()->shouldReturn('Template for "bitbag" block type was not found.');
    }
}
