<?php

namespace Realodix\Assert;

class Helper
{
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

        if (Type::type_has_duplicate(explode('|', $types))) {
            throw new \ErrorException(
                'Duplicate type names in the same declaration is not allowed.'
            );
        }
    }
}
