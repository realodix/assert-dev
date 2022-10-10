<?php

namespace Realodix\Assert;

class Type
{
    private const UNION_SEPARATOR = '|';

    private static $validators = [
        // PHP types
        'array'           => 'is_array',
        'bool'            => 'is_bool',
        'float'           => 'is_float',
        'int'             => 'is_int',
        'numeric'         => 'is_numeric',
        'null'            => 'is_null',
        'object'          => 'is_object',
        'resource'        => 'is_resource',
        'scalar'          => 'is_scalar',
        'string'          => 'is_string',
        'countable'       => 'is_countable',
        'iterable'        => 'is_iterable',
        'callable'        => 'is_callable',
        'empty'           => [Validators::class, 'isEmpty'],
        'not-empty'       => [Validators::class, 'isNotEmpty'],
        'non-empty-array' => [Validators::class, 'isNonEmptyArray'],
        'list'            => [Validators::class, 'isList'],
        'non-empty-list'  => [Validators::class, 'isNonEmptyList'],
        'non-empty-string' => [Validators::class, 'isNonEmptyString'],
        'truthy-string'    => [Validators::class, 'isTruthyString'],
        'true'             => [Validators::class, 'isTrue'],
        'false'            => [Validators::class, 'isFalse'],
        'positive-int'     => [Validators::class, 'isPositiveInt'],
        'negative-int'     => [Validators::class, 'isNegativeInt'],
        'numeric-string'   => [Validators::class, 'isNumericString'],
        'callable-string'  => [Validators::class, 'isCallableString'],
        'lowercase-string' => [Validators::class, 'isLowercaseString'],
    ];

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

        foreach ($types as $item) {
            if (str_ends_with($item, '[]')) {
                if (! Validators::everyIs($value, substr($item, 0, -2))) {
                    throw new Exception\TypeErrorException($typesInArray, $value, $message);
                }

                continue;
            }

            [$type] = $item = explode(' ', $item, 2);
            if (isset(static::$validators[$type])) {
                try {
                    if (! static::$validators[$type]($value)) {
                        throw new Exception\TypeErrorException($typesInArray, $value, $message);
                    }
                } catch (\TypeError $e) {
                    continue;
                }
            } elseif (! $value instanceof $type) {
                continue;
            }
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

        return ($type === $allowedTypes)
            || \is_object($value) && $value instanceof $allowedTypes
            || ('callable' === $allowedTypes) && \is_callable($value)
            || ('scalar' === $allowedTypes) && \is_scalar($value)
            // Array
            || ('countable' === $allowedTypes) && is_countable($value)
            || ('iterable' === $allowedTypes) && is_iterable($value)
            || ('list[]' === $allowedTypes) && Constraint::arrayIsList($value)
            || ('bool[]' === $allowedTypes) && Constraint::arrayIs($value, 'is_bool')
            || ('string[]' === $allowedTypes) && Constraint::arrayIs($value, 'is_string')
            || ('int[]' === $allowedTypes) && Constraint::arrayIs($value, 'is_int')
            || ('float[]' === $allowedTypes) && Constraint::arrayIs($value, 'is_float')
            || ('object[]' === $allowedTypes) && Constraint::arrayIs($value, 'is_object')
            // Boolean
            || ('bool' === $allowedTypes) && \is_bool($value)
            || ('true' === $allowedTypes) && $value === true
            || ('false' === $allowedTypes) && $value === false
            // Number
            || ('numeric' === $allowedTypes) && is_numeric($value)
            || ('int' === $allowedTypes) && \is_int($value)
            || ('positive-int' === $allowedTypes) && \is_int($value) && $value >= 1
            || ('negative-int' === $allowedTypes) && \is_int($value) && $value <= -1
            || ('float' === $allowedTypes) && \is_float($value)
            // ...-string
            || ('truthy-string' === $allowedTypes) && Constraint::truthyString($value)
            || ('lowercase-string' === $allowedTypes) && \is_string($value) && ctype_lower($value)
            || ('numeric-string' === $allowedTypes) && is_numeric($value) && \is_string($value)
            || ('callable-string' === $allowedTypes) && \is_callable($value) && \is_string($value)
            // non-empty-...
            || ('non-empty-string' === $allowedTypes) && Constraint::nonEmptyString($value)
            || ('non-empty-array' === $allowedTypes) && Constraint::nonEmptyArray($value)
            || ('non-empty-list' === $allowedTypes) && Constraint::nonEmptyList($value)
            // Others
            || ('empty' === $allowedTypes) && empty($value)
            || ('not-empty' === $allowedTypes) && ! empty($value);
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

        $types = explode('|', $types);

        foreach (array_count_values(array_map('strtolower', $types)) as $val => $c) {
            $dups = [];

            if ($c > 1) {
                $dups[] = $val;

                throw new \ErrorException(sprintf(
                    'Duplicate type %s is redundant.',
                    $dups[0]
                ));
            }
        }

        if (self::typeHasRedundantMembers($types)) {
            throw new \ErrorException(
                'Union type declarations contain redundant types.'
            );
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
                throw new \ErrorException(
                    'Only class and interface can be part of an intersection type.'
                );
            }
        }

        $actTypesCount = \count($values);
        $expTypesCount = \count(
            array_intersect_key($values, array_unique(array_map('strtolower', $values)))
        );

        if ($expTypesCount < $actTypesCount) {
            throw new \ErrorException(
                'Duplicate type names in the same declaration is not allowed.'
            );
        }
    }

    private static function typeHasRedundantMembers(array $types): bool
    {
        if (\in_array('scalar', $types) &&
            (\in_array('numeric', $types)
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
                (\in_array('positive-int', $types) || \in_array('negative-int', $types))
            || \in_array('array', $types) &&
                (\in_array('bool[]', $types)
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
            || \in_array('string', $types) &&
                (\in_array('non-empty-string', $types)
                || \in_array('truthy-string', $types)
                || \in_array('lowercase-string', $types))
            || \in_array('non-empty-string', $types) &&
                (\in_array('truthy-string', $types)
                || \in_array('lowercase-string', $types))
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param  string[] $types
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
                    case 'non-falsy-string':
                        return 'truthy-string';
                    default:
                        return $type;
                }
            },
            $types
        );
    }
}
