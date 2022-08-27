<?php

namespace Realodix\Assert\Exception;

class SymbolFormatException extends \Exception
{
    /**
     * Creates a new Exception instance.
     */
    public function __construct()
    {
        parent::__construct("Combining '|' and '&' in the same declaration is not allowed.");
    }
}
