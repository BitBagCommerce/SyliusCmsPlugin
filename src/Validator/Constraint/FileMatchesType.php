<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Validator\Constraint;

use Sylius\CmsPlugin\Validator\FileMatchesTypeValidator;
use Symfony\Component\Validator\Constraint;

final class FileMatchesType extends Constraint
{
    public string $messageImage = 'This file cannot be uploaded as an image';

    public string $messageVideo = 'This file cannot be uploaded as an video';

    public string $field;

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return FileMatchesTypeValidator::class;
    }
}
