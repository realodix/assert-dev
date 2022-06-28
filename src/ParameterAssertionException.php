<?php

namespace Realodix\Assert;

use InvalidArgumentException;

/**
 * Exception indicating that an parameter assertion failed.
 * This generally means a disagreement between the caller and the implementation of a function.
 */
class ParameterAssertionException extends InvalidArgumentException implements AssertionException
{
    /**
     * @var string
     */
    private $parameterName;

    /**
     * @throws ParameterTypeException
     */
    public function __construct(string $parameterName, string $description)
    {
        parent::__construct("Bad value for parameter $parameterName: $description");

        $this->parameterName = $parameterName;
    }

    public function getParameterName(): string
    {
        return $this->parameterName;
    }
}
