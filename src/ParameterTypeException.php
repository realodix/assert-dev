<?php

namespace Realodix\Assert;

/**
 * Exception indicating that a parameter type assertion failed.
 * This generally means a disagreement between the caller and the implementation of a function.
 */
class ParameterTypeException extends ParameterAssertionException
{
    /**
     * @var string
     */
    private $parameterType;

    /**
     * @param  string  $parameterName
     * @param  string  $parameterType
     *
     * @throws self
     */
    public function __construct(string $parameterName, string $parameterType)
    {
        parent::__construct($parameterName, "must be a $parameterType");

        $this->parameterType = $parameterType;
    }

    /**
     * @return string
     */
    public function getParameterType(): string
    {
        return $this->parameterType;
    }
}
