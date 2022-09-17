<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase;
use Realodix\Assert\Assert;

class ExceptionMessageTest extends TestCase
{
    public function testExceptionMessage()
    {
        $this->expectExceptionMessage('Expected a string. Got: int.');
        Assert::type(1, 'string');

        $this->expectExceptionMessage('Expected an int. Got: string.');
        Assert::type('1', 'int');
    }

    public function testCustomExceptionMessage()
    {
        $message = 'foobar';

        $this->expectExceptionMessage($message);
        Assert::type(1, 'string', $message);
    }

    public function testInvalidTypeValueForType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Argument #2 (\$types) must 'string or array'.");
        Assert::type(1, true);
    }
}
