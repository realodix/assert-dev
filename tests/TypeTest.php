<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Assert;
use Realodix\Assert\Exception\InvalidTypeDeclarationFormatException;

class TypeTest extends TestCase
{
    use TypeTestProvider;

    /**
     * @dataProvider arrayProvider
     */
    public function testArray($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::type($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider numberProvider
     */
    public function testNumber($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::type($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider objectProvider
     */
    public function testObject($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::type($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isBoolProvider
     */
    public function is_bool($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::type($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider instanceofProvider
     */
    public function instanceof($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::type($type, $value);
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
    public function is_scalar($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::type($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isStringProvider
     */
    public function is_string($type, $value)
    {
        Assert::type($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider intersectionTypesProvider
     */
    public function testIntersectionTypes($type, $value, $pass = true)
    {
        if (! $pass) {
            $this->expectException(InvalidTypeDeclarationFormatException::class);
            $this->expectExceptionMessage(
                'Intersection Types only support class and interface names as intersection members.'
            );
        }

        Assert::type($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * Intersection Types is called "pure" Intersection Types because combining Union
     * Types and Intersection Types in the same declaration is not allowed.
     */
    public function testPureIntersectionTypes()
    {
        $this->expectException(InvalidTypeDeclarationFormatException::class);
        $this->expectExceptionMessage(
            "Combining '|' and '&' in the same declaration is not allowed."
        );
        Assert::type('numeric&int|string', 1);
    }

    /**
     * @dataProvider typeFailProvider
     */
    public function testTypeFail($type, $value)
    {
        $this->testFailed($type, $value);
    }
}
