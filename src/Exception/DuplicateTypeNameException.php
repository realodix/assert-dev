<?php

namespace Realodix\Assert\Exception;

class DuplicateTypeNameException extends \Exception
{
    /**
     * Creates a new Exception instance.
     */
    public function __construct()
    {
        parent::__construct('Duplicate type names in the same declaration is not allowed.');
    }
}
