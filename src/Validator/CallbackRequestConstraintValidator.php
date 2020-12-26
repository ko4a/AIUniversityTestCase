<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;

class CallbackRequestConstraintValidator extends ConstraintValidator
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || !is_array($value)) {
            $this->context->buildViolation($this->translator->trans('callback.data_invalid'))->addViolation();

            return;
        }

        $requiredFields = ['flight_id', 'triggered_at', 'event', 'secret_key'];

        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $value)) {
                $msg = sprintf($this->translator->trans('callback.field_required'), $field);
                $this->context->buildViolation($msg)->addViolation();
            }
        }
    }
}
