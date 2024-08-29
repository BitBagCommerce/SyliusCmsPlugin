<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Exception;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Exception\ImportFailedException;

final class ImportFailedExceptionSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('not blank', 1);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ImportFailedException::class);
    }

    public function it_is_an_exception(): void
    {
        $this->shouldHaveType(\Exception::class);
    }

    public function it_has_custom_message(): void
    {
        $this->getMessage()->shouldReturn('Import failed at index 1. Exception message: not blank');
    }
}
