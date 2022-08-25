<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase;
use Realodix\Assert\Assert;

class AssertTest extends TestCase
{
    use AssertTestProvider;

    protected function errorExpectation()
    {
        return \InvalidArgumentException::class;
    }

    /**
     * @dataProvider validIsTypeProvider
     */
    public function testIsTypePass($type, $value)
    {
        Assert::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider invalidIsTypeProvider
     */
    public function testIsTypeFail($type, $value)
    {
        $this->expectException($this->errorExpectation());

        Assert::isType($type, $value);
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testArray($type, $value, $pass = true)
    {
        if (! $pass) {
            $this->expectException($this->errorExpectation());

            Assert::isType($type, $value);
        }

        Assert::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider numberProvider
     */
    public function testNumber($type, $value, $pass = true)
    {
        if (! $pass) {
            $this->expectException($this->errorExpectation());

            Assert::isType($type, $value);
        }

        Assert::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider objectProvider
     */
    public function testObject($type, $value, $pass = true)
    {
        if (! $pass) {
            $this->expectException($this->errorExpectation());

            Assert::isType($type, $value);
        }

        Assert::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isBoolProvider
     */
    public function is_bool($type, $value, $pass = true)
    {
        if (! $pass) {
            $this->expectException($this->errorExpectation());

            Assert::isType($type, $value);
        }

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
    public function is_scalar($type, $value)
    {
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

    public function testAssert()
    {
        // $this->assertSame('array', get_debug_type(array()));
        // $this->assertTrue([] instanceof \Countable);
        $this->assertCount(0, []);
    }
}
