<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class JobStartValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\JobStart */

        if ($value instanceof \DateTime) {

        }

        $tomorrow = new \DateTime('tomorrow');
        if ($value >= $tomorrow) {
            return;
        }

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value->format('d/m/Y'))
            ->addViolation();
    }
}
