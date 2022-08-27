<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase;
use Realodix\Assert\Assert;

class AssertTest extends TestCase
{
    use AssertTestProvider;

    protected function testFailed($type, $value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assert::isType($type, $value);
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testArray($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider numberProvider
     */
    public function testNumber($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider objectProvider
     */
    public function testObject($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isBoolProvider
     */
    public function is_bool($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider instanceofProvider
     */
    public function instanceof($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function is_null()
    {
        Assert::isType('null', null);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isScalarProvider
     */
    public function is_scalar($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isStringProvider
     */
    public function is_string($type, $value)
    {
        Assert::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    public function testExceptionMessage()
    {
        $this->expectExceptionMessage('Expected a string. Got: integer.');
        Assert::isType('string', 1);

        $this->expectExceptionMessage('Expected an int. Got: string.');
        Assert::isType('int', '1');
    }

    public function testCustomExceptionMessage()
    {
        $message = 'foobar';

        $this->expectExceptionMessage($message);
        Assert::isType('string', 1, $message);
    }

    /**
     * @dataProvider unionTypesProvider
     */
    public function testUnionTypes($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider intersectionTypesProvider
     */
    public function testIntersectionTypes($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * Intersection Types is called "pure" Intersection Types because combining Union
     * Types and Intersection Types in the same declaration is not allowed.
     */
    public function testPureIntersectionTypes()
    {
        $this->expectException(\InvalidArgumentException::class);
        Assert::isType('bool&true|boolean', true);
    }

    /**
     * Redundant type names on pure intersection types
     *
     * Each name-resolved type may only occur once. Types like A&B&A result in an error.
     */
    public function testRedundantTypeNamesOnPureIntersectionTypes()
    {
        $this->expectException(\InvalidArgumentException::class);
        Assert::isType('bool&true&bool', true);
    }

    /**
     * @dataProvider invalidIsTypeProvider
     */
    public function testIsTypeFail($type, $value)
    {
        $this->testFailed($type, $value);
    }
}
