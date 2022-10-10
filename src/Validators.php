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

            [$type] = $item = explode(':', $item, 2);
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

            if (isset($item[1])) {
                $length = $value;
                if (isset(static::$counters[$type])) {
                    $length = static::$counters[$type]($value);
                }

                $range = explode('..', $item[1]);
                if (! isset($range[1])) {
                    $range[1] = $range[0];
                }

                if (($range[0] !== '' && $length < $range[0]) || ($range[1] !== '' && $length > $range[1])) {
                    continue;
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Finds whether all values are of expected types separated by pipe.
     *
     * @param mixed[] $values
     */
    public static function everyIs(iterable $values, string $expected): bool
    {
        foreach ($values as $value) {
            if (! static::is($value, $expected)) {
                return false;
            }
        }

        return true;
    }
}
