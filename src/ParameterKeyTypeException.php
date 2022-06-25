<?php

namespace Realodix\Assert;

/**
 * Exception indicating that a parameter key type assertion failed.
 * This generally means a disagreement between the caller and the implementation of a function.
 */
class ParameterKeyTypeException extends ParameterAssertionException
{
    /**
     * @var string
     */
    private $type;

    /**
     * @param  string  $parameterName
     * @param  string  $type
     *
     * @throws ParameterTypeException
     */
    public function __construct(string $parameterName, string $type)
    {
        parent::__construct($parameterName, "all elements must have $type keys");

        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
