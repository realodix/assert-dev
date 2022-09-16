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

    public static function type_is_duplicate($types): bool
    {
        return true;
    }
}
