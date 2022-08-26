<?php

namespace Realodix\Assert;

class Assert
{
    /**
     * Checks an parameter's type, that is, throws a InvalidArgumentException if $value is
     * not of $type. This is really a special case of Assert::precondition().
     *
     * @param string $types The parameter's expected type. Can be the name of a native
     *                      type or a class or interface, or a list of such names.
     * @param mixed  $value The parameter's actual value.
     *
     * @throws InvalidArgumentException if $value is not of type (or, for objects, is not an
     *                                  instance of) $type.
     */
    public static function isType(string $types, $value, string $message = ''): void
    {
        if (str_contains($types, '|') && str_contains($types, '&')) {
            throw new \InvalidArgumentException(
                'Combining "|" and "&" in the same declaration is not allowed.'
            );
        }

        if ($message === '') {
            $message = sprintf(
                'Expected %s %s. Got: %s.',
                \in_array(lcfirst($types)[0], ['a', 'e', 'i', 'o', 'u'], true) ? 'an' : 'a',
                $types,
                gettype($value)
            );
        }

        // symfony/polyfill-php80
        if (str_contains($types, '&')) {
            if (! self::isIntersectionTypes($value, explode('&', $types))) {
                throw new \InvalidArgumentException($message);
            }

            return;
        }

        if (! self::hasType($value, explode('|', $types))) {
            throw new \InvalidArgumentException($message);
        }
    }

    /**
     * @param mixed $value
     */
    private static function hasType($value, array $aTypes): bool
    {
        foreach ($aTypes as $allowedTypes) {
            if (self::rules($value, $allowedTypes)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param mixed $value
     */
    private static function isIntersectionTypes($value, array $allowedTypes): bool
    {
        $validTypes = array_filter(
            $allowedTypes,
            fn ($allowedTypes) => self::rules($value, $allowedTypes)
        );

        if (count($allowedTypes) === count($validTypes)) {
            return true;
        }

        return false;
    }

    private static function rules($value, string $allowedTypes): bool
    {
        // Apply strtolower because gettype returns "NULL" for null values.
        $type = strtolower(gettype($value));

        return ($type == $allowedTypes)
            || is_object($value) && $value instanceof $allowedTypes
            || ('callable' == $allowedTypes) && is_callable($value)
            || ('scalar' == $allowedTypes) && is_scalar($value)
            // Array
            || ('countable' == $allowedTypes) && is_countable($value)
            || ('iterable' == $allowedTypes) && is_iterable($value)
            // Boolean
            || ('bool' == $allowedTypes) && is_bool($value)
            || ('true' == $allowedTypes) && $value === true
            || ('false' == $allowedTypes) && $value === false
            // Number
            || ('numeric' == $allowedTypes) && is_numeric($value)
            || ('int' == $allowedTypes) && is_int($value)
            || ('float' == $allowedTypes) && is_float($value);
    }
}
