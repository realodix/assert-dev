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
    private $isType;

    /**
     * @param  string  $parameterName
     * @param  string  $isType
     *
     * @throws self
     */
    public function __construct(string $parameterName, string $isType)
    {
        parent::__construct($parameterName, "must be a $isType");

        $this->isType = $isType;
    }

    /**
     * @return string
     */
    public function getParameterType(): string
    {
        return $this->isType;
    }
}
