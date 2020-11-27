<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class ValidationFailedException extends Exception
{
    private iterable $violations;

    public function __construct(iterable $violations)
    {
        parent::__construct('Validation Failed');

        $this->violations = $violations;
    }

    public function getViolations(): iterable
    {
        return $this->violations;
    }
}
