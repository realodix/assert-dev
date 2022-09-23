<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase;
use Realodix\Assert\Assert;

class ExceptionMessageTest extends TestCase
{
    /** @test */
    public function exceptionMessage()
    {
        $this->expectExceptionMessage('Expected a string. Got: int.');
        Assert::type(1, 'string');

        $this->expectExceptionMessage('Expected an int. Got: string.');
        Assert::type('1', 'int');
    }

    /** @test */
    public function customExceptionMessage()
    {
        $message = 'foobar';

        $this->expectExceptionMessage($message);
        Assert::type(1, 'string', $message);
    }

    /** @test */
    public function invalidTypeValueForType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Argument #2 (\$types) must 'string or array'.");
        Assert::type(1, true);
    }
}
