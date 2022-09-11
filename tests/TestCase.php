<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Realodix\Assert\Assert;
use Realodix\Assert\Exception\TypeErrorException;
use Realodix\Assert\Type;

class TestCase extends PHPUnitTestCase
{
    protected function invalidTypes($type, $value)
    {
        $this->expectException(TypeErrorException::class);
        Assert::type($type, $value);
    }

    protected function invalidIntersectionTypes($type, $value)
    {
        $this->expectException(TypeErrorException::class);
        Type::intersection($type, $value);
    }
}
