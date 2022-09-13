<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Assert;

class TypeTest extends TestCase
{
    use TypeTestProvider;

    /**
     * @dataProvider arrayProvider
     */
    public function testArray($value, $types, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider numberProvider
     */
    public function testNumber($value, $types, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider objectProvider
     */
    public function testObject($value, $types, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isBoolProvider
     */
    public function is_bool($value, $types, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider instanceofProvider
     */
    public function instanceof($value, $types, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function is_null()
    {
        Assert::type('null', null);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isScalarProvider
     */
    public function is_scalar($value, $types, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isStringProvider
     */
    public function is_string($value, $types)
    {
        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider typeFailProvider
     */
    public function testTypeFail($value, $types)
    {
        $this->invalidTypes($value, $types);
    }
}
