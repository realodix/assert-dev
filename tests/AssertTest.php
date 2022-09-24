<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Assert;

class AssertTest extends TestCase
{
    use AssertTestProvider;

    /**
     * @test
     * @dataProvider keyExistsProvider
     */
    public function keyExists($key, $value, $pass = true)
    {
        (! $pass) && $this->invalidAssertionValue($value, $key, 'keyExists');

        Assert::keyExists($value, $key);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function keyNotExists()
    {
        $value = ['first' => 1, 'second' => 4];
        $key = 'foo';

        Assert::keyNotExists($value, $key);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function isMap()
    {
        $value = ['string' => true];

        Assert::isMap($value);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function isNonEmptyMap()
    {
        $value = ['string' => ''];

        Assert::isNonEmptyMap($value);
        $this->addToAssertionCount(1);
    }

    public function testCount()
    {
        $value = ['string' => true];

        Assert::count($value, 1);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function maxCount()
    {
        $value = ['string' => true];

        Assert::maxCount($value, 1);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function minCount()
    {
        $value = ['string' => true];

        Assert::minCount($value, 1);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function countBetween()
    {
        $value = ['foo', 'bar', 'baz'];

        Assert::countBetween($value, 1, 3);
        Assert::countBetween($value, 2, 4);
        $this->addToAssertionCount(2);
    }

    /** @test */
    public function validArrayKey()
    {
        Assert::validArrayKey(1);
        $this->addToAssertionCount(1);
    }
}
