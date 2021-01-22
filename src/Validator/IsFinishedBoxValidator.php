<?php

namespace App\Validator;

use App\Entity\Box;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsFinishedBoxValidator extends ConstraintValidator
{
    /**
     * @param Box $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsFinishedBox) {
            throw new UnexpectedTypeException($constraint, IsFinishedBox::class);
        }

        if ($value->getItems()->count() < 5 && $value->getIsFinished() == true) {
            $this->context->buildViolation($constraint->message)
                ->atPath('isFinished')
                ->addViolation();
        }
    }

}
