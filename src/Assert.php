<?php

namespace Realodix\Assert;

class Assert
{
    /**
     * @param  string|array $types
     * @param  mixed        $value
     * @return void|null
     */
    public static function type($value, $types, string $message = '')
    {
        return Type::is($value, $types, $message);
    }
}
