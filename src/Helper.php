<?php

namespace Realodix\Assert;

class Helper
{
    public static function valueToString($value)
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
            if (\method_exists($value, '__toString')) {
                return \get_class($value).': '.self::valueToString($value->__toString());
            }

            if ($value instanceof DateTime || $value instanceof DateTimeImmutable) {
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
     * @param mixed        $value
     */
    public static function assertStringOrArray($value, int $order = 1, string $variable = ''): void
    {
        if (! is_string($value) && ! is_array($value)) {
            throw new \InvalidArgumentException(sprintf(
                "Argument #%s%s must 'string or array'.",
                $order,
                $variable = '' ? '' : ' ('.$variable.')'
            ));
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
        if (preg_match('/^[a-z-A-Z|\\\:]+$/', $types) === 0) {
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

        if (self::type_has_duplicate(explode('|', $types))) {
            throw new \ErrorException(
                'Duplicate type names in the same declaration is not allowed.'
            );
        }
    }

    /**
     * @param string|array $types
     */
    public static function type_has_duplicate($types): bool
    {
        self::assertStringOrArray($types , 1, '$types');

        if (is_string($types)) {
            $types = explode('|', $types);
        }

        if (in_array('scalar', $types) &&
                (in_array('numeric', $types)
                || in_array('int', $types)
                || in_array('float', $types)
                || in_array('string', $types)
                || in_array('bool', $types))
            || in_array('numeric', $types) &&
                (in_array('int', $types)
                || in_array('float', $types))) {
            return true;
        }

        // Tidak boleh ada 2 nama tipe atau lebih dalam satu deklarasi yang sama.
        $actualTypesCount = count($types);
        $expectedTypesCount = count(array_unique($types));
        if ($expectedTypesCount < $actualTypesCount) {
            return true;
        }

        return false;
    }

    /**
     * @param string|array $types
     */
    public static function normalize_type($types): array
    {
        if (! is_string($types) && ! is_array($types)) {
            throw new \InvalidArgumentException(
                "Argument #1 (\$types) must 'string or array'."
            );
        }

        if (is_string($types)) {
            $types = explode('|', $types);
        }

        return array_map(
            function ($type) {
                switch ($type) {
                    case 'double':
                        return 'float';
                    case 'integer':
                        return 'int';
                    case 'boolean':
                        return 'bool';
                    default:
                        return $type;
                }
            },
            $types
        );
    }
}
