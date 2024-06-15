<?php

namespace Realodix\Assert;

class Helper
{
    /**
     * @param mixed $value
     */
    public static function typeToString($value): string
    {
        return \is_object($value) ? \get_class($value) : \gettype($value);
    }

    /**
     * @param mixed $value
     */
    public static function valueToString($value): string
    {
        if ($value === null) {
            return 'null';
        }

        if ($value === true) {
            return 'true';
        }

        if ($value === false) {
            return 'false';
        }

        if (\is_array($value)) {
            return 'array';
        }

        if (\is_object($value)) {
            if (method_exists($value, '__toString')) {
                return \get_class($value).': '.self::valueToString($value->__toString());
            }

            if ($value instanceof \DateTime || $value instanceof \DateTimeImmutable) {
                return \get_class($value).': '.self::valueToString($value->format('c'));
            }

            return \get_class($value);
        }

        if (\is_resource($value)) {
            return 'resource';
        }

        if (\is_string($value)) {
            return '"'.$value.'"';
        }

        return (string) $value;
    }

    /**
     * @param mixed $value
     */
    public static function assertStringOrArray($value, string $variable = '', int $order = 1): void
    {
        if (! \is_string($value) && ! \is_array($value)) {
            throw new \InvalidArgumentException(sprintf(
                "Argument #%s%s must 'string or array'.",
                $order,
                empty($variable) ? '' : ' ('.$variable.')'
            ));
        }
    }
}
