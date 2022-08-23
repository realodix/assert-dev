<?php

namespace Realodix\Assert;

class Assert
{
    /**
     * Checks a parameter, that is, throws a ParameterAssertionException if $condition is false.
     * This is similar to Assert::precondition().
     *
     * @note This is intended for checking parameters in constructors and setters.
     * Checking parameters in every function call is not recommended, since it may have a
     * negative impact on performance.
     *
     * @param string $name        The name of the parameter that was checked.
     * @param string $description The message to include in the exception if the condition fails.
     *
     * @throws ParameterAssertionException if $condition is not true.
     * @psalm-assert bool $condition
     */
    public static function parameter(bool $condition, string $name, string $description): void
    {
        if (! $condition) {
            throw new ParameterAssertionException($name, $description);
        }
    }

    /**
     * Checks an parameter's type, that is, throws a InvalidArgumentException if $value is
     * not of $type. This is really a special case of Assert::precondition().
     *
     * @param string|string[] $types The parameter's expected type. Can be the name of a native type
     *                               or a class or interface, or a list of such names.
     * @param mixed           $value The parameter's actual value.
     * @param string          $name  The name of the parameter that was checked.
     *
     * @throws ParameterTypeException if $value is not of type (or, for objects, is not an
     *                                instance of) $type.
     */
    public static function isType($types, $value, string $name): void
    {
        if (is_string($types)) {
            $types = explode('|', $types);
        }
        if (! self::hasType($value, $types)) {
            throw new ParameterTypeException($name, implode('|', $types));
        }
    }

    /**
     * @param mixed    $value
     * @param string[] $allowedTypes
     */
    private static function hasType($value, array $allowedTypes): bool
    {
        // Apply strtolower because gettype returns "NULL" for null values.
        $type = strtolower(gettype($value));

        if (
            in_array($type, $allowedTypes)
            || is_object($value) && self::isInstanceOf($value, $allowedTypes)
        ) {
            return true;
        }

        if (
            in_array('callable', $allowedTypes) && is_callable($value)
            || in_array('int', $allowedTypes) && is_int($value)
            || in_array('float', $allowedTypes) && is_float($value)
            || in_array('bool', $allowedTypes) && is_bool($value)
            || in_array('false', $allowedTypes) && $value === false
            || in_array('true', $allowedTypes) && $value === true
        ) {
            return true;
        }

        if (in_array('countable', $allowedTypes) && is_countable($value)
            || in_array('iterable', $allowedTypes) && is_iterable($value)) {
            return true;
        }

        if (in_array('numeric', $allowedTypes) && is_numeric($value)) {
            return true;
        }

        if (in_array('scalar', $allowedTypes) && is_scalar($value)) {
            return true;
        }

        return false;
    }

    /**
     * @param object   $value
     * @param string[] $allowedTypes
     */
    private static function isInstanceOf($value, array $allowedTypes): bool
    {
        foreach ($allowedTypes as $type) {
            if ($value instanceof $type) {
                return true;
            }
        }

        return false;
    }
}
