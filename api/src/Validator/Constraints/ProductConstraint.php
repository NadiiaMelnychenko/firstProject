<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute]
class ProductConstraint extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return get_class($this) . 'Validator';
    }
//    public function getTargets(): string
//    {
//        return self::CLASS_CONSTRAINT;
//    }
}