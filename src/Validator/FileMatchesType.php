<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Validator;

use Symfony\Component\Validator\Constraint;


final class FileMatchesType extends Constraint
{
    public $messageImage = 'This file cannot be uploaded as an image';

    public $messageVideo = 'This file cannot be uploaded as an video';

    public $field;

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
