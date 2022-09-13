<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase;
use Realodix\Assert\Assert;

class ExceptionMessageTest extends TestCase
{
    public function testExceptionMessage()
    {
        $this->expectExceptionMessage('Expected a string. Got: integer.');
        Assert::type('string', 1);

        $this->expectExceptionMessage('Expected an int. Got: string.');
        Assert::type('int', '1');
    }

    public function testCustomExceptionMessage()
    {
        $message = 'foobar';

        $this->expectExceptionMessage($message);
        Assert::type(1, 'string', $message);
    }
}
