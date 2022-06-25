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
     * @param  string  $parameterName
     * @param  string  $description
     *
     * @throws ParameterTypeException
     */
    public function __construct($parameterName, $description)
    {
        if (! is_string($parameterName)) {
            throw new ParameterTypeException('parameterName', 'string');
        }

        if (! is_string($description)) {
            throw new ParameterTypeException('description', 'string');
        }

        parent::__construct("Bad value for parameter $parameterName: $description");

        $this->parameterName = $parameterName;
    }

    /**
     * @return string
     */
    public function getParameterName(): string
    {
        return $this->parameterName;
    }
}
