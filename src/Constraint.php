<?php

namespace Realodix\Assert;

class Constraint
{
    /**
     * @param mixed $value
     */
    public static function arrayIs($value, callable $callback): bool
    {
        $result = true;

        // $value = \Aimeos\Map::from($value)->toArray();

        if (empty($value)) {
            return false;
        }

        foreach ($value as $val) {
            if (! $callback($val)) {
                $result = false;
            }
        }

        return $result;
    }
}
