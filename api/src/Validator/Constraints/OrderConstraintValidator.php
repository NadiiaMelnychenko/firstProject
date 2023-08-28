<?php

namespace App\Validator\Constraints;

use App\Entity\Order;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class OrderConstraintValidator extends ConstraintValidator
{
    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof OrderConstraint) {
            throw new UnexpectedTypeException($constraint, OrderConstraint::class);
        }

        if (!$value instanceof Order) {
            throw new UnexpectedTypeException($value, Order::class);
        }

        if (empty($value->getProducts())) {
            $this->context->addViolation("Add products");
        }

        if ($value->getProductsAmount()>3) {
            $this->context->addViolation("No more than 3 products");
        }

        if ($value->getSum()>1000) {
            $this->context->addViolation("The order amount is too large");
        }
    }
}
