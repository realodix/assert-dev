<?php

namespace Realodix\Assert;

class Constraint
{
    public static function arrayIsEmpty(array $value): bool
    {
        return empty($value);
    }

    public static function arrayIs(array $value, callable $callback): bool
    {
        $result = true;

        foreach ($value as $val) {
            if (! $callback($val)) {
                $result = false;
            }
        }

        return $result;
    }
}
