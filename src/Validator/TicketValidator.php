<?php

namespace App\Validator;

use App\Service\ValidationService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TicketValidator extends ConstraintValidator
{
    private ValidationService $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        $this->validationService->ticketValidation($value, $this->context);
    }
}
