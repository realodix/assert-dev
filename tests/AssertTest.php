<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase;
use Realodix\Assert\Assert;
use Realodix\Assert\ParameterAssertionException;
use Realodix\Assert\ParameterTypeException;

class AssertTest extends TestCase
{
    use AssertTestProvider;

    /**
     * @dataProvider validIsTypeProvider
     *
     * @param mixed $type
     * @param mixed $value
     */
    public function testIsTypePass($type, $value)
    {
        Assert::isType($type, $value, 'test');
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider invalidIsTypeProvider
     */
    public function testIsTypeFail($type, $value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assert::isType($type, $value, 'test');
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testArray()
    {
        Assert::isType('array', [], 'test');
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider numberProvider
     */
    public function testNumber($type, $value)
    {
        Assert::isType($type, $value, 'test');
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider objectProvider
     */
    public function testObject($type, $value)
    {
        Assert::isType($type, $value, 'test');
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isBoolProvider
     */
    public function is_bool($type, $value)
    {
        Assert::isType($type, $value, 'test');
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function is_null()
    {
        Assert::isType('null', null, 'test');
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isScalarProvider
     */
    public function is_scalar($type, $value)
    {
        Assert::isType($type, $value, 'test');
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isStringProvider
     */
    public function is_string($type, $value)
    {
        Assert::isType($type, $value, 'test');
        $this->addToAssertionCount(1);
    }

    public function testAssert()
    {
        // $this->assertSame('array', get_debug_type(array()));
        // $this->assertTrue([] instanceof \Countable);
        $this->assertCount(0, []);
    }
}
