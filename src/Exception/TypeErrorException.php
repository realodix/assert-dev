<?php

namespace Realodix\Assert\Exception;

class TypeErrorException extends \Exception
{
    /**
     * @param mixed $value
     */
    public function __construct(string $types, $value, string $message)
    {
        if ($message === '') {
            $message = sprintf(
                'Expected %s %s. Got: %s.',
                \in_array(lcfirst($types)[0], ['a', 'e', 'i', 'o', 'u'], true) ? 'an' : 'a',
                $types,
                // symfony/polyfill-php80
                get_debug_type($value),
            );
        }

        parent::__construct($message);
    }
}
