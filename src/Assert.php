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

    public static function type_has_duplicate($types): bool
    {
        $types = explode('|', $types);

        if (
            in_array('scalar', $types)
                && in_array('numeric', $types)
        ) {
            return true;
        }

        return false;
    }

    private static function normalizeType(array $types): array
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
