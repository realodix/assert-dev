<?php

namespace Realodix\Assert;

class Assert
{
    /**
     * @param  mixed           $value
     * @param  string|string[] $types
     * @return void|null
     */
    public static function type($value, $types, string $message = '')
    {
        return Type::is($value, $types, $message);
    }

    public static function keyExists($array, $key, $message = ''): void
    {
        if (! (isset($array[$key]) || \array_key_exists($key, $array))) {
            self::generateMessage(sprintf(
                $message ?: 'Expected the key %s to exist.',
                Helper::valueToString($key)
            ));
        }
    }

    public static function keyNotExists($array, $key, $message = ''): void
    {
        if (isset($array[$key]) || \array_key_exists($key, $array)) {
            self::generateMessage(sprintf(
                $message ?: 'Expected the key %s to not exist.',
                Helper::valueToString($key)
            ));
        }
    }

    public static function isMap($array, $message = '')
    {
        if (! \is_array($array)
            || array_keys($array) !== array_filter(array_keys($array), 'is_string')) {
            self::generateMessage(
                $message ?: 'Expected map - associative array with string keys.'
            );
        }
    }

    public static function isNonEmptyMap($array, $message = '')
    {
        self::isMap($array, $message);
        self::notEmpty($array, $message);
    }

    public static function count($array, $number, $message = '')
    {
        if (\count($array) != $number) {
            self::generateMessage(sprintf(
                $message ?: 'Expected an array to contain %d elements. Got: %d.',
                $number,
                \count($array)
            ));
        }
    }

    public static function maxCount($array, $max, $message = '')
    {
        if (\count($array) > $max) {
            self::generateMessage(sprintf(
                $message ?: 'Expected an array to contain at most %2$d elements. Got: %d',
                \count($array),
                $max
            ));
        }
    }

    public static function minCount($array, $min, $message = '')
    {
        if (\count($array) < $min) {
            self::generateMessage(sprintf(
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
            self::generateMessage(sprintf(
                $message ?: 'Expected an array to contain between %2$d and %3$d elements. Got: %d',
                $count,
                $min,
                $max
            ));
        }
    }

    public static function validArrayKey($value, $message = '')
    {
        if (! (\is_int($value) || \is_string($value))) {
            self::generateMessage(sprintf(
                $message ?: 'Expected string or integer. Got: %s',
                Helper::typeToString($value)
            ));
        }
    }

    public static function notEmpty($value, $message = '')
    {
        if (empty($value)) {
            self::generateMessage(sprintf(
                $message ?: 'Expected a non-empty value. Got: %s',
                Helper::valueToString($value)
            ));
        }
    }

    protected static function generateMessage($message): string
    {
        throw new \InvalidArgumentException($message);
    }
}
