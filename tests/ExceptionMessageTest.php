<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Type;

class ExceptionMessageTest extends TestCase
{
    public function testExceptionMessage()
    {
        $this->expectExceptionMessage('Expected a string. Got: integer.');
        Type::is('string', 1);

        $this->expectExceptionMessage('Expected an int. Got: string.');
        Type::is('int', '1');
    }

    public function testCustomExceptionMessage()
    {
        $message = 'foobar';

        $this->expectExceptionMessage($message);
        Type::is('string', 1, $message);
    }
}
