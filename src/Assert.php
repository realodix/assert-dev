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
}
