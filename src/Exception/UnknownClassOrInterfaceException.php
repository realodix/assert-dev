<?php

namespace Realodix\Assert\Exception;

/**
 * @codeCoverageIgnore
 */
class UnknownClassOrInterfaceException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Class or Interface does not exist.');
    }
}
