<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\MediaProvider;

use BitBag\SyliusCmsPlugin\MediaProvider\FilenameHelper;
use PhpSpec\ObjectBehavior;

class FilenameHelperSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(FilenameHelper::class);
    }

    public function it_removes_slashes_from_the_string()
    {
        $string = 'path/to/file';
        $expectedResult = 'pathtofile';

        $this->removeSlashes($string)->shouldBe($expectedResult);
    }

    public function it_replaces_slashes_with_the_provided_string()
    {
        $string = 'path/to/file';
        $replaceWith = '-';
        $expectedResult = 'path-to-file';

        $this->removeSlashes($string, $replaceWith)->shouldBe($expectedResult);
    }

    public function it_does_not_modify_the_string_if_no_slashes_are_present()
    {
        $string = 'filename';
        $expectedResult = 'filename';

        $this->removeSlashes($string)->shouldBe($expectedResult);
    }
}
