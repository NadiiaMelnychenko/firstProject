<?php

namespace App\Validator\Constraints;

use App\Entity\Category;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CategoryConstraintValidator extends ConstraintValidator
{
    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof CategoryConstraint) {
            throw new UnexpectedTypeException($constraint, CategoryConstraint::class);
        }

        if (!$value instanceof Category) {
            throw new UnexpectedTypeException($value, Category::class);
        }

        if (empty($value->getName())) {
            $this->context->addViolation("Name is empty");
        }

        if (!preg_match('/^[a-zA-Z ]+$/', $value->getType())) {
            $this->context->addViolation("Wrong type of category");
        }
    }
}