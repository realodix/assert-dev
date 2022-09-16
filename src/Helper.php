<?php

namespace Realodix\Assert;

class Helper
{
    public static function type_has_duplicate(string $types): bool
    {
        $types = explode('|', $types);

        if (in_array('scalar', $types) &&
                (in_array('numeric', $types)
                || in_array('int', $types)
                || in_array('float', $types)
                || in_array('string', $types)
                || in_array('bool', $types))
            || in_array('numeric', $types) &&
                (in_array('int', $types)
                || in_array('float', $types))) {
            return true;
        }

        return false;
    }

    public static function normalizeType(array $types): array
    {
        return array_map(
            function ($type) {
                switch ($type) {
                    case 'double':
                        return 'float';
                    case 'integer':
                        return 'int';
                    case 'boolean':
                        return 'bool';
                    default:
                        return $type;
                }
            },
            $types
        );
    }
}
