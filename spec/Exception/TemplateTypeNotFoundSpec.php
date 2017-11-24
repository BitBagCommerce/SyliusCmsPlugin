<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Exception;

use BitBag\SyliusCmsPlugin\Exception\TemplateTypeNotFound;
use PhpSpec\ObjectBehavior;

final class TemplateTypeNotFoundSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('bitbag');
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(TemplateTypeNotFound::class);
    }

    function it_is_an_exception(): void
    {
        $this->shouldHaveType(\Exception::class);
    }

    function it_has_custom_message(): void
    {
        $this->getMessage()->shouldReturn('Template type "bitbag" was not found.');
    }
}
