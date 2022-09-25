<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Realodix\Assert\Assert;
use Realodix\Assert\Exception\TypeErrorException;
use Realodix\Assert\Type;

class TestCase extends PHPUnitTestCase
{
    protected function invalidType($value, $types)
    {
        $this->expectException(TypeErrorException::class);
        Assert::type($value, $types);
    }

    protected function invalidElementType($value, $types)
    {
        $this->expectException(TypeErrorException::class);
        Type::inArray($value, $types);
    }

    protected function invalidAssertion(string $callback, ...$actual)
    {
        $this->expectException(\InvalidArgumentException::class);
        Assert::$callback(...$actual);
    }
}
