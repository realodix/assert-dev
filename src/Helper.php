<?php

namespace Realodix\Assert;

class Helper
{
    /**
     * @param mixed $value
     */
    public static function typeToString($value): string
    {
        return \is_object($value) ? \get_class($value) : \gettype($value);
    }

    /**
     * @param mixed $value
     */
    public static function valueToString($value): string
    {
        if (null === $value) {
            return 'null';
        }

        if (true === $value) {
            return 'true';
        }

        if (false === $value) {
            return 'false';
        }

        if (\is_array($value)) {
            return 'array';
        }

        if (\is_object($value)) {
            if (method_exists($value, '__toString')) {
                return \get_class($value).': '.self::valueToString($value->__toString());
            }

            if ($value instanceof \DateTime || $value instanceof \DateTimeImmutable) {
                return \get_class($value).': '.self::valueToString($value->format('c'));
            }

            return \get_class($value);
        }

        if (\is_resource($value)) {
            return 'resource';
        }

        if (\is_string($value)) {
            return '"'.$value.'"';
        }

        return (string) $value;
    }

    /**
     * @param mixed $value
     */
    public static function assertStringOrArray($value, string $variable = '', int $order = 1): void
    {
        if (! \is_string($value) && ! \is_array($value)) {
            throw new \InvalidArgumentException(sprintf(
                "Argument #%s%s must 'string or array'.",
                $order,
                $variable = empty($variable) ? '' : ' ('.$variable.')'
            ));
        }
    }

    /**
     * @throws \ErrorException
     * @throws Exception\UnknownClassOrInterfaceException
     */
    public static function assertIntersectionTypeMember(array $values): void
    {
        foreach ($values as $value) {
            if (\is_string($value) && preg_match('/\\\/', $value) === 1
                && ! interface_exists($value) && ! class_exists($value)) {
                // https://github.com/flashios09/php-union-types/blob/master/src/Exception/ClassNotFoundException.php
                throw new Exception\UnknownClassOrInterfaceException;
            }

            if (! interface_exists($value) && ! class_exists($value)) {
                throw new \ErrorException(
                    'Only class and interface can be part of an intersection type.'
                );
            }
        }

        if (self::typeHasDuplicateMembers($values)) {
            throw new \ErrorException(
                'Duplicate type names in the same declaration is not allowed.'
            );
        }
    }

    /**
     * Periksa deklarasi format tipe. Ini harus dapat memastikan format yang
     * diberikan merupakan format yang valid.
     *
     * @throws \ErrorException
     */
    public static function assertTypeDeclaration(string $types): void
    {
        if (preg_match('/^[\[\]\-|a-zA-Z\\\:]+$/', $types) === 0) {
            throw new \ErrorException(
                "Only '|' symbol that allowed."
            );
        }

        // Simbol harus diletakkan diantara nama tipe
        if (preg_match('/^([\|])|([\|])$/', $types) > 0) {
            throw new \ErrorException(
                'Symbols must be between type names.'
            );
        }

        // Tidak boleh ada duplikat simbol
        if (preg_match('/(\|\|)/', $types) > 0) {
            throw new \ErrorException(
                'Duplicate symbols are not allowed.'
            );
        }

        if (self::typeHasDuplicateMembers(explode('|', $types))) {
            throw new \ErrorException(
                'Duplicate type names in the same declaration is not allowed.'
            );
        }

        if (self::typeHasRedundantMembers(explode('|', $types))) {
            throw new \ErrorException(
                'Type declarations has redundant types.'
            );
        }
    }

    /**
     * @param string|array $types
     */
    private static function typeHasDuplicateMembers($types): bool
    {
        Helper::assertStringOrArray($types, '$types');

        if (\is_string($types)) {
            $types = explode('|', $types);
        }

        $actTypesCount = \count($types);
        $expTypesCount = \count(
            array_intersect_key($types, array_unique(array_map('strtolower', $types)))
        );
        if ($expTypesCount < $actTypesCount) {
            return true;
        }

        return false;
    }

    /**
     * @param string|array $types
     */
    private static function typeHasRedundantMembers($types): bool
    {
        Helper::assertStringOrArray($types, '$types');

        if (\is_string($types)) {
            $types = explode('|', $types);
        }

        if (\in_array('scalar', $types) && (
                \in_array('numeric', $types)
                || \in_array('int', $types)
                || \in_array('positive-int', $types)
                || \in_array('negative-int', $types)
                || \in_array('float', $types)
                || \in_array('string', $types)
                || \in_array('bool', $types))
            || \in_array('bool', $types) &&
                (\in_array('true', $types) || \in_array('false', $types))
            || \in_array('numeric', $types) &&
                (\in_array('int', $types)
                || \in_array('positive-int', $types)
                || \in_array('negative-int', $types)
                || \in_array('float', $types))
            || \in_array('int', $types) &&
                (\in_array('positive-int', $types)
                || \in_array('negative-int', $types))
            || \in_array('array', $types) && (
                \in_array('bool[]', $types)
                || \in_array('string[]', $types)
                || \in_array('int[]', $types)
                || \in_array('float[]', $types)
                || \in_array('object[]', $types)
                || \in_array('list[]', $types)
                || \in_array('non-empty-array', $types)
                || \in_array('non-empty-list', $types))
            || \in_array('non-empty-array', $types) &&
                (\in_array('list[]', $types) || (\in_array('non-empty-list', $types)))
            || \in_array('list[]', $types) && \in_array('non-empty-list', $types)
            || \in_array('string', $types) && (
                \in_array('non-empty-string', $types)
                || \in_array('lowercase-string', $types))
            || \in_array('non-empty-string', $types) && (
                \in_array('lowercase-string', $types))
        ) {
            return true;
        }

        return false;
    }
}
