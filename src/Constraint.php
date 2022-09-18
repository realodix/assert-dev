<?php

namespace Realodix\Assert;

class Constraint
{
    public static function arrayIsEmpty(array $value): bool
    {
        return empty($value);
    }
}
