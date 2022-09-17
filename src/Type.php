<?php

namespace Realodix\Assert;

class Type
{
    /**
     * Checks an parameter's type, that is, throws a InvalidArgumentException if
     * $value is not of $type.
     *
     * @param mixed        $value The parameter's actual value.
     * @param string|array $types The parameter's expected type. Can be the name of a native
     *                            type or a class or Interface, or a list of such names.
     *
     * @throws \InvalidArgumentException
     * @throws Exception\TypeErrorException If $value is not of type (or for objects,
     *                                      is not an instance of) $type.
     */
    public static function is($value, $types, string $message = ''): void
    {
        Helper::assertStringOrArray($types, '$types', 2);

        if (is_string($types)) {
            $types = Helper::normalize_type(explode('|', $types));
            Helper::assertTypeDeclaration(implode('|', $types));
        }

        if (! self::hasType($value, $types)) {
            throw new Exception\TypeErrorException(
                implode('|', $types), $value, $message
            );
        }
    }

    /**
     * https://gist.github.com/Pierstoval/ed387a09d4a5e76108e60e8a7585ac2d
     *
     * @param mixed        $value The parameter's actual value.
     * @param string|array $types The parameter's expected type.
     *
     * @throws \InvalidArgumentException
     * @throws Exception\TypeErrorException
     */
    public static function intersection($value, $types, string $message = ''): void
    {
        Helper::assertStringOrArray($types, '$types', 2);

        if (is_string($types)) {
            $types = explode(' ', $types);
        }

        if (! self::intersectionTypesValidator($value, $types)) {
            throw new Exception\TypeErrorException(
                implode(' & ', $types), $value, $message
            );
        }
    }

    /**
     * @param mixed $value
     *
     * @throws \ErrorException
     * @throws Exception\UnknownClassOrInterfaceException
     */
    private static function intersectionTypesValidator($value, array $types): bool
    {
        Helper::assertIntersectionTypeMember($types);

        if (Helper::type_has_duplicate($types)) {
            throw new \ErrorException(
                'Duplicate type names in the same declaration is not allowed.'
            );
        }

        $validTypes = array_filter($types, fn ($types) => $value instanceof $types);
        if (count($types) === count($validTypes)) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $value
     */
    private static function hasType($value, array $allowedTypes): bool
    {
        foreach ($allowedTypes as $aTypes) {
            if (self::rules($value, $aTypes)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param mixed $value
     */
    private static function rules($value, string $allowedTypes): bool
    {
        // Apply strtolower because gettype returns "NULL" for null values.
        $type = strtolower(gettype($value));

        return ($type === $allowedTypes)
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
