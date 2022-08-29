<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Type;

class TypeTest extends TestCase
{
    use TypeTestProvider;

    /**
     * @dataProvider arrayProvider
     */
    public function testArray($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Type::is($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider numberProvider
     */
    public function testNumber($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Type::is($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider objectProvider
     */
    public function testObject($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Type::is($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isBoolProvider
     */
    public function is_bool($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Type::is($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider instanceofProvider
     */
    public function instanceof($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Type::is($type, $value);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function is_null()
    {
        Type::is('null', null);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isScalarProvider
     */
    public function is_scalar($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Type::is($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isStringProvider
     */
    public function is_string($type, $value)
    {
        Type::is($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider invalidTypeProvider
     */
    public function testisFail($type, $value)
    {
        $this->testFailed($type, $value);
    }
}
