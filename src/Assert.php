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
}
