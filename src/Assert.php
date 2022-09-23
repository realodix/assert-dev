<?php

namespace Realodix\Assert;

class Assert
{
    /**
     * @param  mixed        $value
     * @param  string|array $types
     * @return void|null
     */
    public static function type($value, $types, string $message = '')
    {
        return Type::is($value, $types, $message);
    }

    public static function keyExists($array, $key, $message = ''): void
    {
        if (! (isset($array[$key]) || \array_key_exists($key, $array))) {
            throw new \InvalidArgumentException(\sprintf(
                $message ?: 'Expected the key %s to exist.',
                Helper::valueToString($key)
            ));
        }
    }

    public static function keyNotExists($array, $key, $message = ''): void
    {
        if ((isset($array[$key]) || \array_key_exists($key, $array))) {
            throw new \InvalidArgumentException(\sprintf(
                $message ?: 'Expected the key %s to not exist.',
                Helper::valueToString($key)
            ));
        }
    }

    public static function isMap($array, $message = '')
    {
        if (! \is_array($array)
            || \array_keys($array) !== \array_filter(\array_keys($array), 'is_string')) {
            throw new \InvalidArgumentException(
                $message ?: 'Expected map - associative array with string keys.'
            );
        }
    }

    public static function isNonEmptyMap($array, $message = '')
    {
        self::isMap($array, $message);
        self::notEmpty($array, $message);
    }

    public static function maxCount($array, $max, $message = '')
    {
        if (\count($array) > $max) {
            throw new \InvalidArgumentException(\sprintf(
                $message ?: 'Expected an array to contain at most %2$d elements. Got: %d',
                \count($array),
                $max
            ));
        }
    }

    public static function minCount($array, $min, $message = '')
    {
        if (\count($array) < $min) {
            throw new \InvalidArgumentException(\sprintf(
                $message ?: 'Expected an array to contain at least %2$d elements. Got: %d',
                \count($array),
                $min
            ));
        }
    }

    public static function countBetween($array, $min, $max, $message = '')
    {
        $count = \count($array);

        if ($count < $min || $count > $max) {
            throw new \InvalidArgumentException(\sprintf(
                $message ?: 'Expected an array to contain between %2$d and %3$d elements. Got: %d',
                $count,
                $min,
                $max
            ));
        }
    }

    public static function notEmpty($value, $message = '')
    {
        if (empty($value)) {
            throw new \InvalidArgumentException(\sprintf(
                $message ?: 'Expected a non-empty value. Got: %s',
                Helper::valueToString($value)
            ));
        }
    }
}
