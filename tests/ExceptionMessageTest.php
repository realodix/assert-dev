<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Assert;

class ExceptionMessageTest extends TestCase
{
    public function testExceptionMessage()
    {
        $this->expectExceptionMessage('Expected a string. Got: integer.');
        Assert::isType('string', 1);

        $this->expectExceptionMessage('Expected an int. Got: string.');
        Assert::isType('int', '1');
    }

    public function testCustomExceptionMessage()
    {
        $message = 'foobar';

        $this->expectExceptionMessage($message);
        Assert::isType('string', 1, $message);
    }
}
