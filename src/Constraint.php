<?php

namespace Realodix\Assert;

class Constraint
{
    public static function arrayIsEmpty(array $value): bool
    {
        return empty($value);
    }

    public static function arrayIsNumeric(array $value): bool
    {
        $result = true;

        foreach ($value as $val) {
            if (! is_numeric($val)) {
                $result = false;
            }
        }

        return $result;
    }
}
