<?php

namespace App\Validator\Constraints;

use App\Entity\Product;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ProductConstraintValidator extends ConstraintValidator
{
    const MAX_PRICE = 90;

    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ProductConstraint) {
            throw new UnexpectedTypeException($constraint, ProductConstraint::class);
        }

        if (!$value instanceof Product) {
            throw new UnexpectedTypeException($value, Product::class);
        }

        if (empty($value->getName())) {
            $this->context->addViolation("Name is empty");
        }

        if ($value->getPrice() > self::MAX_PRICE) {
            $this->context->addViolation("Price should be < " . self::MAX_PRICE);
        }
    }
}