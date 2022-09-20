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

        if (! \is_array($value) || empty($value)) {
            return false;
        }

        foreach ($value as $val) {
            if (! $callback($val)) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * https://www.php.net/manual/en/function.array-is-list.php
     *
     * @param mixed $value
     */
    public static function arrayIsList($value): bool
    {
        if (! \is_array($value)) {
            return false;
        }

        // symfony/polyfill-php81
        return array_is_list($value);
    }

    /**
     * https://www.php.net/manual/en/function.array-is-list.php
     *
     * @param mixed $value
     */
    public static function nonEmptyString($value): bool
    {
        if (! \is_string($value)) {
            return false;
        }

        if (empty($value)) {
            return false;
        }

        return true;
    }
}
