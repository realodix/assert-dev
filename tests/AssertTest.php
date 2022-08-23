<?php

namespace Realodix\Assert\Tests;

use PHPUnit\Framework\TestCase;
use Realodix\Assert\Assert;
use Realodix\Assert\ParameterAssertionException;
use Realodix\Assert\ParameterTypeException;

class AssertTest extends TestCase
{
    use AssertTestProvider;

    public function testParameterPass()
    {
        Assert::parameter(1 >= 0, 'foo', 'must be greater than 0');
        $this->addToAssertionCount(1);
    }

    public function testParameterFail()
    {
        try {
            Assert::parameter(false, 'test', 'testing');
            $this->fail('Expected ParameterAssertionException');
        } catch (ParameterAssertionException $ex) {
            $this->assertSame('test', $ex->getParameterName());
        }
    }

    public function testParameterTypeCatch()
    {
        $this->expectException(ParameterAssertionException::class);
        Assert::isType('string', 17, 'test');
    }

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
        try {
            Assert::isType($type, $value, 'test');
            $this->fail('Expected ParameterTypeException');
        } catch (ParameterTypeException $ex) {
            $this->assertSame($type, $ex->getParameterType());
            $this->assertSame('test', $ex->getParameterName());
        }
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
