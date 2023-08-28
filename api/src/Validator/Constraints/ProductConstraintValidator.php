<?php

namespace App\Validator\Constraints;

use App\Entity\Product;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ProductConstraintValidator extends ConstraintValidator
{
    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
//        if (!$constraint instanceof ProductConstraint) {
//            throw new UnexpectedTypeException($constraint, ProductConstraint::class);
//        }
//
//        if (!$value instanceof Product) {
//            throw new UnexpectedTypeException($value, Product::class);
//        }

        if (empty($value)) {
            $this->context->addViolation("Price is empty");
        }

        if (!preg_match('/^[0-9]+$/', $value)) {
            $this->context->addViolation("Price is wrong");
        }
    }
}