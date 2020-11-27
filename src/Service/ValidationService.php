<?php

namespace App\Service;

use App\Exception\ValidationFailedException;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ValidationService
{
    private TranslatorInterface $translator;
    private FlightService $flightService;

    public function __construct(TranslatorInterface $translator, FlightService $flightService)
    {
        $this->translator = $translator;
        $this->flightService = $flightService;
    }

    public function ticketValidation($value, ExecutionContextInterface $context): void
    {
        if (null === $value->getFlight()) {
            $context->buildViolation($this->translator->trans('flight.not_exist'))->addViolation();
            throw new ValidationFailedException($context->getViolations());
        }

        if (!$this->flightService->isSeatFree($value->getFlight(), $value->getSeatNumber())) {
            $context->buildViolation($this->translator->trans('flight.seat_is_not_free'))->addViolation();
            throw new ValidationFailedException($context->getViolations());
        }

        if ($value->getFlight()->isSalesCompleted()) {
            $context->buildViolation($this->translator->trans('flight.sales_completed'))->addViolation();
            throw new ValidationFailedException($context->getViolations());
        }
    }
}
