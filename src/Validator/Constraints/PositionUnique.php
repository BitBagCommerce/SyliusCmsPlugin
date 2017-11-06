<?php

namespace BitBag\CmsPlugin\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use BitBag\CmsPlugin\Validator\Constraints\PositionUniqueValidator;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 *
 */

class PositionUnique extends Constraint
{
    public $message = 'This value asdasdasdasdas is already used.{{ string }}';
    public $service = 'validator.position_unique_validator';

    /**
     * {@inheritdoc}
     */
    public function getTargets(): array
    {
        return [self::PROPERTY_CONSTRAINT, self::CLASS_CONSTRAINT];
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy(): string
    {
        return $this->service;
    }
}