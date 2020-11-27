<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Reservation extends Constraint
{
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
