<?php

namespace Realodix\Assert;

class Constraint
{
    /**
     * @param mixed $value
     *
     * @psalm-assert-if-false !list[] $value
     */
    public static function arrayIs($value, callable $callback): bool
    {
        $result = true;

        if (! self::arrayIsList($value) || empty($value)) {
            return false;
        }

        // if (! array_product(array_map($callback, $value))) {
        //     $result = false;
        // }
        foreach ($value as $val) {
            if (! $callback($val)) {
                $result = false;
            }
        }

        return $result;
    }

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

    /**
     * Check that a value is a string, and not empty
     *
     * @param mixed $value
     */
    public static function nonEmptyString($value): bool
    {
        if (! \is_string($value) || \strlen($value) === 0) {
            return false;
        }

        return true;
    }

    /**
     * Is any string that is true after casting to boolean.
     * Effectively a subtype of non-empty-string
     *
     * @param mixed $value
     */
    public static function truthyString($value): bool
    {
        if (! \is_string($value) || (bool) $value === false) {
            return false;
        }

        return true;
    }
}
