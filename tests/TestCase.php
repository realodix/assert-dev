<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Realodix\Assert\Assert;
use Realodix\Assert\Exception\InvalidArgumentTypeException;

class TestCase extends PHPUnitTestCase
{
    protected function testFailed($type, $value)
    {
        $this->expectException(InvalidArgumentTypeException::class);

        Assert::type($type, $value);
    }
}
