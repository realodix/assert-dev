<?php

namespace Realodix\Assert;

class Constraint
{
    public static function arrayIsEmpty(array $value): bool
    {
        return empty($value);
    }

    /**
     * @param mixed $value
     */
    public static function arrayIs($value, callable $callback): bool
    {
        $result = true;

        $value = \Aimeos\Map::from($value)->toArray();

        foreach ($value as $val) {
            if (! $callback($val)) {
                $result = false;
            }
        }

        return $result;
    }
}
