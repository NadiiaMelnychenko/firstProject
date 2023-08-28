<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute]
class OrderConstraint extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return get_class($this) . "Validator";
    }

    /**
     * @return string
     */
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
