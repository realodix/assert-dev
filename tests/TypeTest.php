<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Assert;
use Realodix\Assert\Constraint;

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
     * @dataProvider isStringProvider
     */
    public function is_string($types, $value)
    {
        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider arrayIsProvider
     */
    public function arrayIs($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidTypes($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider arrayIsWithInvalidInputProvider
     */
    public function arrayIsWithInvalidInput($types, $value)
    {
        $this->invalidTypes($value, $types);
    }

    /**
     * @test
     */
    public function arrayKeyValueIs()
    {

        $this->assertTrue(
            Constraint::arrayKeyValueIs(['1a' => 'true'], 'is_string')
        );
    }
}
