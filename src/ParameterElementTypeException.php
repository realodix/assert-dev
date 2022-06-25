<?php

namespace Realodix\Assert;

/**
 * Exception indicating that a parameter element type assertion failed.
 * This generally means a disagreement between the caller and the implementation of a function.
 */
class ParameterElementTypeException extends ParameterAssertionException
{
    /**
     * @var string
     */
    private $elementType;

    /**
     * @param  string  $parameterName
     * @param  string  $elementType
     *
     * @throws ParameterTypeException
     */
    public function __construct($parameterName, $elementType)
    {
        if (! is_string($elementType)) {
            throw new ParameterTypeException('elementType', 'string');
        }

        parent::__construct($parameterName, "all elements must be $elementType");

        $this->elementType = $elementType;
    }

    /**
     * @return string
     */
    public function getElementType(): string
    {
        return $this->elementType;
    }
}
