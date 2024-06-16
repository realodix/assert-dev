<?php

namespace Realodix\Assert;

class Constraint
{
    /**
     * Check that a value is an array, and not empty
     *
     * @param mixed $value
     */
    public static function nonEmptyArray($value): bool
    {
        if (! \is_array($value) || empty(array_filter($value))) {
            return false;
        }

        return true;
    }
}
