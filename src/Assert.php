<?php

namespace Realodix\Assert;

class Assert
{
    /**
     * @param  string|array|object $types
     * @param  mixed               $value
     * @param  bool                $isection
     * @return void|null
     */
    public static function type($types, $value, string $message = '')
    {
        return Type::is($types, $value, $message);
    }
}
