<?php

namespace Realodix\Assert;

class Constraint
{
    /**
     * Checks whether a given array is a list
     * https://www.php.net/manual/en/function.array-is-list.php
     *
     * @param mixed $value
     *
     * @psalm-assert-if-false !list[] $value
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
     * Checks whether a given array is a list, and not empty
     *
     * @param mixed $value
     */
    public static function nonEmptyList($value): bool
    {
        $result = true;

        if (! self::arrayIsList($value)) {
            return false;
        }

        if (empty(array_filter($value))) {
            $result = false;
        }

        foreach ($value as $val) {
            if (empty($val)) {
                $result = false;
            }
        }

        return $result;
    }

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
