<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Validator\Constraint;

use BitBag\SyliusCmsPlugin\Validator\FileMatchesTypeValidator;
use Symfony\Component\Validator\Constraint;

final class FileMatchesType extends Constraint
{
    /** @var string */
    public $messageImage = 'This file cannot be uploaded as an image';

    /** @var string */
    public $messageVideo = 'This file cannot be uploaded as an video';

    /** @var string */
    public $field;

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return FileMatchesTypeValidator::class;
    }
}
