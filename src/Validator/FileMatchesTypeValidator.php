<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Validator;

use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Validator\Constraint\FileMatchesType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class FileMatchesTypeValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof FileMatchesType) {
            throw new UnexpectedTypeException($constraint, FileMatchesType::class);
        }
        if (null === $value->getPath() && null === $value->getFile()) {
            return;
        }

        if ($value->hasFile() && null !== $value->getFile()->getMimeType()) {
            return;
        }

        $mime = $value->hasFile() ? $value->getFile()->getMimeType() : $value->getMimeType();

        if (MediaInterface::IMAGE_TYPE === $value->getType() && !(str_starts_with($mime, 'image/'))) {
            $this->context->buildViolation($constraint->messageImage)
                ->addViolation()
            ;
        }

        if (MediaInterface::VIDEO_TYPE === $value->getType() && !(str_starts_with($mime, 'video/'))) {
            $this->context->buildViolation($constraint->messageVideo)
                ->atPath($constraint->field)
                ->addViolation()
            ;
        }
    }
}
