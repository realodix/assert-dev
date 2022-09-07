<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Assert;
use Realodix\Assert\Exception\FatalErrorException;
use Realodix\Assert\Tests\Fixtures\ClassAB;

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
    public function testIntersectionTypes($type, $value)
    {
        Assert::type($type, $value, '', true);
        $this->addToAssertionCount(1);
    }

    public function testIntersectionTypesWithObjectDoesNotExist()
    {
        $this->expectException(FatalErrorException::class);
        $this->expectExceptionMessage(
            'Class or interface does not exist.'
        );

        Assert::type(fooBar::class, new ClassAB, '', true);
    }

    public function testIntersectionTypesWithUnsupportedMember()
    {
        $this->expectException(FatalErrorException::class);
        $this->expectExceptionMessage(
            'Intersection Types only support class and interface names as intersection members.'
        );

        Assert::type(['string', true], new ClassAB, '', true);
    }

    /**
     * @dataProvider typeFailProvider
     */
    public function testTypeFail($type, $value)
    {
        $this->testFailed($type, $value);
    }
}
