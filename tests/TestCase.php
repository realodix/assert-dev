<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Realodix\Assert\Assert;
use Realodix\Assert\Exception\TypeErrorException;

class TestCase extends PHPUnitTestCase
{
    protected function invalidType($value, $types)
    {
        $this->expectException(TypeErrorException::class);
        Assert::type($value, $types);
    }

    protected function invalidAssertionValue($value, $types, string $callback)
    {
        $this->expectException(TypeErrorException::class);
        Assert::$callback($value, $types);
    }
}
