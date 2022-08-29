<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Realodix\Assert\Type;

class TestCase extends PHPUnitTestCase
{
    protected function testFailed($type, $value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Type::is($type, $value);
    }
}
