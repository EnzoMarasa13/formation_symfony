<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StartBeforeEndValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\StartBeforeEnd */

        $job = $protocol;

       // vérifier si date de debut est inférieur à date de fin
        return;

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->atPath('startDate')
            ->addViolation();
    }
}
