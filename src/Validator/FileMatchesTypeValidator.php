<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Validator;

use BitBag\SyliusCmsPlugin\Entity\Media;
use BitBag\SyliusCmsPlugin\Validator\Constraint\FileMatchesType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class FileMatchesTypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof FileMatchesType) {
            throw new UnexpectedTypeException($constraint, FileMatchesType::class);
        }

        if ($value->hasFile() && empty($value->getFile()->getMimeType())) {
            return;
        }

        $mime = $value->hasFile() ? $value->getFile()->getMimeType() : $value->getMimeType();

        if ($value->getType() === Media::IMAGE_TYPE && !(str_starts_with($mime, 'image/'))) {
            $this->context->buildViolation($constraint->messageImage)
                ->addViolation();
        }

        if ($value->getType() === Media::VIDEO_TYPE && !(str_starts_with($mime, 'video/'))) {
            $this->context->buildViolation($constraint->messageVideo)
                ->atPath($constraint->field)
                ->addViolation();
        }
    }
}
