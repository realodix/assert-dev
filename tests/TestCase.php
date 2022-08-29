<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Realodix\Assert\Assert;

class TestCase extends PHPUnitTestCase
{
    protected function testFailed($type, $value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assert::type($type, $value);
    }
}
