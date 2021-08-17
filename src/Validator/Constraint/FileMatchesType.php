<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
