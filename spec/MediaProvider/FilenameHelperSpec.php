<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\MediaProvider;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\MediaProvider\FilenameHelper;

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
