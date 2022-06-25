<?php

namespace Realodix\Assert;

use RuntimeException;

/**
 * Exception indicating that an precondition assertion failed.
 * This generally means a disagreement between the caller and the implementation of a function.
 */
class PreconditionException extends RuntimeException implements AssertionException
{
}
