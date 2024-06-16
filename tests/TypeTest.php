<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Assert;
use Realodix\Assert\Type;

class TypeTest extends TestCase
{
    use TypeTestProvider;

    /**
     * @dataProvider arrayProvider
     */
    public function testArray($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider numberProvider
     */
    public function testNumber($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider objectProvider
     */
    public function testObject($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider instanceofProvider
     */
    public function instanceof($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isBoolProvider
     */
    public function is_bool($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

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
     * @dataProvider isStringProvider
     */
    public function is_string($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider arrayIsListProvider
     */
    public function arrayIsList($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider elementProvider
     */
    public function everyIs($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidElementType($value, $types);

        Type::everyIs($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider arrayIsWithInvalidInputProvider
     */
    public function arrayIsWithInvalidInput($types, $value)
    {
        $this->invalidType($value, $types);
    }

    /**
     * @dataProvider emptyProvider
     */
    public function testEmpty($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider nonEmptyProvider
     */
    public function nonEmpty($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }
}
