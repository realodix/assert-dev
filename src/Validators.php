<?php

namespace Realodix\Assert;

use Nette\Utils\Arrays;
use Nette\Utils\Strings;
use Nette\StaticClass;

/**
 * Validation utilities.
 */
class Validators
{
    use StaticClass;

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

        // pseudo-types
        'callable'   => [self::class, 'isCallable'],
        'iterable'   => 'is_iterable',
        'list'       => [Arrays::class, 'isList'],
        'mixed'      => [self::class, 'isMixed'],
        'none'       => [self::class, 'isNone'],
        'number'     => [self::class, 'isNumber'],
        'numeric'    => [self::class, 'isNumeric'],
        'numericint' => [self::class, 'isNumericInt'],

        // string patterns
        'alnum'   => 'ctype_alnum',
        'alpha'   => 'ctype_alpha',
        'digit'   => 'ctype_digit',
        'lower'   => 'ctype_lower',
        'pattern' => null,
        'space'   => 'ctype_space',
        'unicode' => [self::class, 'isUnicode'],
        'upper'   => 'ctype_upper',
        'xdigit'  => 'ctype_xdigit',

        // syntax validation
        'email'      => [self::class, 'isEmail'],
        'identifier' => [self::class, 'isPhpIdentifier'],
        'uri'        => [self::class, 'isUri'],
        'url'        => [self::class, 'isUrl'],

        // environment validation
        'class'     => 'class_exists',
        'interface' => 'interface_exists',
        'directory' => 'is_dir',
        'file'      => 'is_file',
        'type'      => [self::class, 'isType'],
    ];

    /** @var array<string, callable> */
    protected static $counters = [
        'string'  => 'strlen',
        'unicode' => [Strings::class, 'length'],
        'array'   => 'count',
        'list'    => 'count',
        'alnum'   => 'strlen',
        'alpha'   => 'strlen',
        'digit'   => 'strlen',
        'lower'   => 'strlen',
        'space'   => 'strlen',
        'upper'   => 'strlen',
        'xdigit'  => 'strlen',
    ];

    /**
     * Verifies that the value is of expected types separated by pipe.
     */
    public static function is(mixed $value, string $expected): bool
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
}
