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

    /**
     * @param int|string $key
     */
    public static function keyExists(array $array, $key, string $message = ''): void
    {
        self::type($key, 'int|string');

        if (! (isset($array[$key]) || \array_key_exists($key, $array))) {
            self::generateMessage(sprintf(
                $message ?: 'Expected the key %s to exist.',
                Helper::valueToString($key)
            ));
        }
    }

    /**
     * @param int|string $key
     */
    public static function keyNotExists(array $array, $key, string $message = ''): void
    {
        self::type($key, 'int|string');

        if (isset($array[$key]) || \array_key_exists($key, $array)) {
            self::generateMessage(sprintf(
                $message ?: 'Expected the key %s to not exist.',
                Helper::valueToString($key)
            ));
        }
    }

    public static function isMap(array $array, string $message = ''): void
    {
        if (array_keys($array) !== array_filter(array_keys($array), 'is_string')) {
            self::generateMessage(
                $message ?: 'Expected map - associative array with string keys.'
            );
        }
    }

    public static function isNonEmptyMap(array $array, string $message = ''): void
    {
        self::isMap($array, $message);
        self::notEmpty($array, $message);
    }

    /**
     * @param \Countable|array $array
     */
    public static function count($array, int $number, string $message = ''): void
    {
        self::type($array, 'countable|array');

        if (\count($array) != $number) {
            self::generateMessage(sprintf(
                $message ?: 'Expected an array to contain %d elements. Got: %d.',
                $number,
                \count($array)
            ));
        }
    }

    /**
     * @param \Countable|array $array
     */
    public static function maxCount($array, int $max, string $message = ''): void
    {
        self::type($array, 'countable|array');

        if (\count($array) > $max) {
            self::generateMessage(sprintf(
                $message ?: 'Expected an array to contain at most %2$d elements. Got: %d',
                \count($array),
                $max
            ));
        }
    }

    /**
     * @param \Countable|array $array
     *
     * @psalm-assert string[] $min
     */
    public static function minCount($array, int $min, string $message = ''): void
    {
        self::type($array, 'countable|array');

        if (\count($array) < $min) {
            self::generateMessage(sprintf(
                $message ?: 'Expected an array to contain at least %2$d elements. Got: %d',
                \count($array),
                $min
            ));
        }
    }

    /**
     * @param \Countable|array $array
     */
    public static function countBetween($array, int $min, int $max, string $message = ''): void
    {
        self::type($array, 'countable|array');

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

    /**
     * @param mixed $value
     */
    public static function validArrayKey($value, string $message = ''): void
    {
        if (! (\is_int($value) || \is_string($value))) {
            self::generateMessage(sprintf(
                $message ?: 'Expected string or integer. Got: %s',
                Helper::typeToString($value)
            ));
        }
    }

    /**
     * @param mixed $value
     */
    public static function notEmpty($value, string $message = ''): void
    {
        if (empty($value)) {
            self::generateMessage(sprintf(
                $message ?: 'Expected a non-empty value. Got: %s',
                Helper::valueToString($value)
            ));
        }
    }

    protected static function generateMessage(string $message): string
    {
        throw new \InvalidArgumentException($message);
    }
}
