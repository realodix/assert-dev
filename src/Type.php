<?php

namespace Realodix\Assert;

class Type
{
    private const UNION_SEPARATOR = '|';

    /**
     * Checks an parameter's type, that is, throws a InvalidArgumentException if
     * $value is not of $type.
     *
     * @param mixed           $value The parameter's actual value.
     * @param string|string[] $types The parameter's expected type. Can be the name of a native
     *                               type or a class or Interface, or a list of such names.
     *
     * @throws \InvalidArgumentException
     * @throws Exception\TypeErrorException If $value is not of type (or for objects,
     *                                      is not an instance of) $type.
     *
     * @psalm-assert string|string[] $types
     */
    public static function is($value, $types, string $message = ''): void
    {
        Helper::assertStringOrArray($types, '$types', 2);

        $types = \is_string($types) ?
            self::normalizeType(explode(self::UNION_SEPARATOR, $types))
            : self::normalizeType($types);
        $typesInArray = implode(self::UNION_SEPARATOR, $types);
        self::assertTypeDeclaration($typesInArray);

        if (! self::hasType($value, $types)) {
            throw new Exception\TypeErrorException($typesInArray, $value, $message);
        }
    }

    /**
     * @param list[]          $values
     * @param string|string[] $types
     *
     * @psalm-assert string|string[] $types
     */
    public static function everyIs(array $values, $types, string $message = ''): void
    {
        self::is($types, 'string|array');

        $types = \is_string($types) ?
            self::normalizeType(explode(self::UNION_SEPARATOR, $types))
            : self::normalizeType($types);
        $typesInString = implode(self::UNION_SEPARATOR, $types);
        self::assertTypeDeclaration($typesInString);

        foreach ($values as $value) {
            if (! self::hasType($value, $types)) {
                throw new Exception\TypeErrorException($typesInString, $value, $message);
            }
        }
    }

    /**
     * https://gist.github.com/Pierstoval/ed387a09d4a5e76108e60e8a7585ac2d
     *
     * @param mixed           $value The parameter's actual value.
     * @param string|string[] $types The parameter's expected type.
     *
     * @throws \InvalidArgumentException
     * @throws Exception\TypeErrorException
     */
    public static function intersection($value, $types, string $message = ''): void
    {
        Helper::assertStringOrArray($types, '$types', 2);

        if (\is_string($types)) {
            $types = explode(' ', $types);
        }

        self::assertIntersectionTypeMember($types);

        $validTypes = array_filter($types, fn ($types) => $value instanceof $types);
        if (\count($types) !== \count($validTypes)) {
            throw new Exception\TypeErrorException(
                implode(' & ', $types), $value, $message
            );
        }
    }

    /**
     * @param mixed    $value
     * @param string[] $allowedTypes
     */
    private static function hasType($value, array $allowedTypes): bool
    {
        foreach ($allowedTypes as $type) {
            if (self::rules($value, $type)) {
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
        // Apply strtolower because gettype() returns "NULL" for null values.
        $type = strtolower(\gettype($value));

        $typeMap = [
            'object'    => 'is_object',
            'callable'  => 'is_callable',
            'countable' => 'is_countable',
            'iterable'  => 'is_iterable',
            'bool'      => 'is_bool',
            'true'      => fn ($value) => $value === true,
            'false'     => fn ($value) => $value === false,
            'int'       => 'is_int',
            'float'     => 'is_float',
        ];

        if (isset($typeMap[$allowedTypes])) {
            if (\is_string($typeMap[$allowedTypes])) {
                return $typeMap[$allowedTypes]($value);
            }

            return $typeMap[$allowedTypes]($value, $allowedTypes);
        }

        if (\is_object($value)) {
            return $value instanceof $allowedTypes;
        }

        return $type === $allowedTypes;
    }

    /**
     * Periksa deklarasi format tipe. Ini harus dapat memastikan format yang
     * diberikan merupakan format yang valid.
     *
     * @throws \ErrorException
     */
    private static function assertTypeDeclaration(string $types): void
    {
        if (preg_match('/^[\[\]\-|a-zA-Z\\\:]+$/', $types) === 0) {
            throw new \ErrorException("Only '|' symbol that allowed.");
        }

        // Simbol harus diletakkan diantara nama tipe
        if (preg_match('/^([\|])|([\|])$/', $types) > 0) {
            throw new \ErrorException('Symbols must be between type names.');
        }

        // Tidak boleh ada duplikat simbol
        if (preg_match('/(\|\|)/', $types) > 0) {
            throw new \ErrorException('Duplicate symbols are not allowed.');
        }

        $types = explode('|', $types);

        foreach (array_count_values(array_map('strtolower', $types)) as $val => $c) {
            $dups = [];

            if ($c > 1) {
                $dups[] = $val;

                throw new \ErrorException(sprintf('Duplicate type %s is redundant.', $dups[0]));
            }
        }

        if (self::typeHasRedundantMembers($types)) {
            throw new \ErrorException('Union type declarations contain redundant types.');
        }
    }

    /**
     * @param string[] $values
     *
     * @throws \ErrorException
     * @throws Exception\UnknownClassOrInterfaceException
     *
     * @psalm-assert class-string[] $values
     */
    private static function assertIntersectionTypeMember(array $values): void
    {
        foreach ($values as $value) {
            if (preg_match('/\\\/', $value) === 1
                && ! interface_exists($value) && ! class_exists($value)) {
                // https://github.com/flashios09/php-union-types/blob/master/src/Exception/ClassNotFoundException.php
                throw new Exception\UnknownClassOrInterfaceException;
            }

            if (! interface_exists($value) && ! class_exists($value)) {
                throw new \ErrorException('Only class and interface can be part of an intersection type.');
            }
        }

        $actTypesCount = \count($values);
        $expTypesCount = \count(
            array_intersect_key($values, array_unique(array_map('strtolower', $values)))
        );

        if ($expTypesCount < $actTypesCount) {
            throw new \ErrorException('Duplicate type names in the same declaration is not allowed.');
        }
    }

    private static function typeHasRedundantMembers(array $types): bool
    {
        $redundantPairs = [
            'bool' => ['true', 'false'],
        ];

        foreach ($types as $type) {
            if (isset($redundantPairs[$type]) && array_intersect($redundantPairs[$type], $types)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string[] $types
     * @return string[]
     */
    private static function normalizeType(array $types): array
    {
        return array_map(
            function (string $type) {
                switch ($type) {
                    case 'double':
                        return 'float';
                    case 'integer':
                        return 'int';
                    case 'boolean':
                        return 'bool';
                    case 'NULL':
                        return 'null';
                    default:
                        return $type;
                }
            },
            $types
        );
    }
}
