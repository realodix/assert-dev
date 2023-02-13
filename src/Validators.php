<?php

namespace Realodix\Assert;

class Validators
{
    /** @var array<string, ?callable> */
    protected static $validators = [
        // PHP types
        'array'    => 'is_array',
        'bool'     => 'is_bool',
        'boolean'  => 'is_bool',
        'float'    => 'is_float',
        'int'      => 'is_int',
        'integer'  => 'is_int',
        'null'     => 'is_null',
        'object'   => 'is_object',
        'resource' => 'is_resource',
        'scalar'   => 'is_scalar',
        'string'   => 'is_string',
    ];

    /** @var array<string, callable> */
    protected static $counters = [
        'string' => 'strlen',
        'array'  => 'count',
        'list'   => 'count',
        'alnum'  => 'strlen',
        'alpha'  => 'strlen',
        'digit'  => 'strlen',
        'lower'  => 'strlen',
        'space'  => 'strlen',
        'upper'  => 'strlen',
        'xdigit' => 'strlen',
    ];

    /**
     * @param mixed $value
     */
    public static function isEmpty($value): bool
    {
        return empty($value);
    }

    /**
     * @param mixed $value
     */
    public static function isNotEmpty($value): bool
    {
        if (self::isEmpty($value)) {
            return false;
        }

        return true;
    }

    /**
     * @param mixed $value
     */
    public static function isNonEmptyArray($value): bool
    {
        if (! \is_array($value) || empty(array_filter($value))) {
            return false;
        }

        return true;
    }

    /**
     * @param mixed $value
     */
    public static function isList($value): bool
    {
        if (! \is_array($value)) {
            return false;
        }

        // symfony/polyfill-php81
        return array_is_list($value);
    }

    /**
     * Checks whether a given array is a list, and not empty
     *
     * @param mixed $value
     */
    public static function isNonEmptyList($value): bool
    {
        $result = true;

        if (! self::isList($value)) {
            return false;
        }

        if (empty(array_filter($value))) {
            $result = false;
        }

        foreach ($value as $val) {
            if (empty($val)) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * Check that a value is a string, and not empty
     *
     * @param mixed $value
     */
    public static function isNonEmptyString($value): bool
    {
        if (! \is_string($value) || \strlen($value) === 0) {
            return false;
        }

        return true;
    }

    /**
     * Is any string that is true after casting to boolean.
     * Effectively a subtype of non-empty-string
     *
     * @param mixed $value
     */
    public static function isTruthyString($value): bool
    {
        if (! \is_string($value) || (bool) $value === false) {
            return false;
        }

        return true;
    }

    /**
     * @param mixed $value
     */
    public static function isTrue($value): bool
    {
        if (! \is_bool($value) || ! $value === true) {
            return false;
        }

        return true;
    }

    /**
     * @param mixed $value
     */
    public static function isFalse($value): bool
    {
        if (! \is_bool($value) || ! $value === false) {
            return false;
        }

        return true;
    }

    /**
     * @param mixed $value
     */
    public static function isPositiveInt($value): bool
    {
        if (\is_int($value) && $value >= 1) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $value
     */
    public static function isNegativeInt($value): bool
    {
        if (\is_int($value) && $value <= -1) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $value
     */
    public static function isNumericString($value): bool
    {
        if (is_numeric($value) && \is_string($value)) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $value
     */
    public static function isCallableString($value): bool
    {
        if (\is_callable($value) && \is_string($value)) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $value
     */
    public static function isLowercaseString($value): bool
    {
        if (\is_string($value) && ctype_lower($value)) {
            return true;
        }

        return false;
    }

    /**
     * Verifies that the value is of expected types separated by pipe.
     */
    public static function is($value, string $expected): bool
    {
        foreach (explode('|', $expected) as $item) {
            if (str_ends_with($item, '[]')) {
                if (is_iterable($value) && self::everyIs($value, substr($item, 0, -2))) {
                    return true;
                }

                continue;
            } elseif (str_starts_with($item, '?')) {
                $item = substr($item, 1);
                if ($value === null) {
                    return true;
                }
            }

            [$type] = $item = explode(' ', $item, 2);
            if (isset(static::$validators[$type])) {
                try {
                    if (! static::$validators[$type]($value)) {
                        continue;
                    }
                } catch (\TypeError $e) {
                    continue;
                }
            } elseif (! $value instanceof $type) {
                continue;
            }

            // if (isset($item[1])) {
            //     $length = $value;
            //     if (isset(static::$counters[$type])) {
            //         $length = static::$counters[$type]($value);
            //     }

            //     $range = explode('..', $item[1]);
            //     if (! isset($range[1])) {
            //         $range[1] = $range[0];
            //     }

            //     if (($range[0] !== '' && $length < $range[0]) || ($range[1] !== '' && $length > $range[1])) {
            //         continue;
            //     }
            // }

            return true;
        }

        return false;
    }

    /**
     * Finds whether all values are of expected types separated by pipe.
     *
     * @param mixed[] $values
     */
    public static function everyIs($values, string $expected): bool
    {
        if (! \is_array($values)) {
            return false;
        }

        foreach ($values as $value) {
            if (! static::is($value, $expected)) {
                return false;
            }
        }

        return true;
    }
}
