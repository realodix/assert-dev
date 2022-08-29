<?php

namespace Realodix\Assert;

class Assert
{
    public static function type(string $types, $value, string $message = '')
    {
        return Type::is($types, $value, $message);
    }
}
