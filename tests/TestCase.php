<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Realodix\Assert\Assert;
use Realodix\Assert\Exception\TypeErrorException;

class TestCase extends PHPUnitTestCase
{
    protected function testInvalidTypes($type, $value)
    {
        $this->expectException(TypeErrorException::class);

        Assert::type($type, $value);
    }
}
