<?php

namespace Realodix\Assert;

class Type
{
    /**
     * Checks an parameter's type, that is, throws a InvalidArgumentException if
     * $value is not of $type.
     *
     * @param string|array|object $types    The parameter's expected type. Can be the name
     *                                      of a native type or a class or interface, or a
     *                                      list of such names.
     * @param mixed               $value    The parameter's actual value.
     * @param bool                $isection
     *
     * @throws Exception\InvalidArgumentTypeException If $value is not of type (or for objects,
     *                                                is not an instance of) $type.
     */
    public static function is($types, $value, string $message = '', $isection = false): void
    {
        if (is_array($types) && $isection === true) {
            if (! self::isIntersectionTypes($value, $types)) {
                throw new Exception\InvalidArgumentTypeException(implode($types), $value, $message);
            }
        }

        if (is_string($types)) {
            self::assertTypeFormatDeclaration($types);
            $types = explode('|', $types);
        }

        if (! self::hasType($value, $types)) {
            throw new Exception\InvalidArgumentTypeException(implode($types), $value, $message);
        }
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
    private static function isIntersectionTypes($value, array $allowedTypes): bool
    {
        if (! interface_exists(implode($allowedTypes))) {
            throw new Exception\InvalidTypeDeclarationFormatException(
                'Intersection Types only support class and interface names as intersection members.'
            );
        }

        $validTypes = array_filter(
            $allowedTypes,
            fn ($allowedTypes) => $value instanceof $allowedTypes
        );

        if (count($allowedTypes) === count($validTypes)) {
            return true;
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

    /**
     * Periksa deklarasi format tipe. Ini harus dapat memastikan format yang
     * diberikan merupakan format yang valid.
     *
     * @throws Exception\InvalidTypeDeclarationFormatException
     */
    private static function assertTypeFormatDeclaration(string $types): void
    {
        if (preg_match('/^[a-z-A-Z|\\\:]+$/', $types) === 0) {
            throw new Exception\InvalidTypeDeclarationFormatException(
                "Only '|' symbol that allowed."
            );
        }

        // Simbol harus diletakkan diantara nama tipe
        if (preg_match('/^([\|])|([\|])$/', $types) > 0) {
            throw new Exception\InvalidTypeDeclarationFormatException(
                'Symbols must be between type names.'
            );
        }

        // Tidak boleh ada duplikat simbol
        if (preg_match('/(\|\|)/', $types) > 0) {
            throw new Exception\InvalidTypeDeclarationFormatException(
                'Duplicate symbols are not allowed.'
            );
        }

        // Tidak boleh ada 2 nama tipe atau lebih dalam satu deklarasi yang sama.
        $typeInArrayForm = explode('|', $types);
        $actualTypesCount = count(array_count_values($typeInArrayForm));
        $expectedTypesCount = count($typeInArrayForm);

        if ($expectedTypesCount != $actualTypesCount) {
            throw new Exception\InvalidTypeDeclarationFormatException(
                'Duplicate type names in the same declaration is not allowed.'
            );
        }
    }
}
