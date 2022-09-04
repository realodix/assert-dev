<?php

namespace Realodix\Assert;

class Assert
{
    /**
     * @param mixed $value
     * @return null
     */
    public static function type(string $types, $value, string $message = '')
    {
        return Type::is($types, $value, $message);
    }
}
