<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Ticket extends Constraint
{
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
