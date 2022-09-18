<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Assert;

class TypeTest extends TestCase
{
    use TypeTestProvider;

    /**
     * @dataProvider arrayProvider
     */
    public function testArray($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider numberProvider
     */
    public function testNumber($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider objectProvider
     */
    public function testObject($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isBoolProvider
     */
    public function is_bool($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider instanceofProvider
     */
    public function instanceof($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function is_null()
    {
        Assert::type(null, 'null');
        Assert::type(null, 'NULL');
        $this->addToAssertionCount(2);
    }

    /**
     * @test
     * @dataProvider isScalarProvider
     */
    public function is_scalar($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider arrayWithVariantProvider
     */
    public function arrayWithVariant($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider string_provider
     */
    public function arrayOfString($value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, 'string[]');

        Assert::type([$value], 'string[]');
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider string_provider
     */
    public function is_string($value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, 'string');

        Assert::type($value, 'string');
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider int_provider
     */
    public function arrayOfInteger($value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, 'int[]');

        Assert::type([$value], 'int[]');
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider int_provider
     */
    public function is_int($value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, 'int');

        Assert::type($value, 'int');
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider float_provider
     */
    public function arrayOfFloat($value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, 'float[]');

        Assert::type([$value], 'float[]');
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider float_provider
     */
    public function is_float($value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, 'float');

        Assert::type($value, 'float');
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider arrayOfObjectProvider
     */
    public function arrayOfObject($value, $pass = true)
    {
        (! $pass) && $this->invalidTypes([$value], 'object[]');

        Assert::type([$value], 'object[]');
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     */
    public function arrayOfObject2()
    {


        Assert::type([], 'object[]');
        $this->addToAssertionCount(1);
    }
}
