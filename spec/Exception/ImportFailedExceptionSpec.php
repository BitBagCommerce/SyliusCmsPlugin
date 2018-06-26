<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Exception;

use BitBag\SyliusCmsPlugin\Exception\ImportFailedException;
use PhpSpec\ObjectBehavior;

final class ImportFailedExceptionSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('not blank', 1);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ImportFailedException::class);
    }

    function it_is_an_exception(): void
    {
        $this->shouldHaveType(\Exception::class);
    }

    function it_has_custom_message(): void
    {
        $this->getMessage()->shouldReturn('Import failed at index 1. Exception message: not blank');
    }
}
