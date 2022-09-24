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
        (! $pass) && $this->invalidAssertion('keyExists', $value, $key);

        Assert::keyExists($value, $key);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider keyNotExistsProvider
     */
    public function keyNotExists($key, $value, $pass = true)
    {
        (! $pass) && $this->invalidAssertion('keyNotExists', $value, $key);

        Assert::keyNotExists($value, $key);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider isMapProvider
     */
    public function isMap($value, $pass = true)
    {
        (! $pass) && $this->invalidAssertion('isMap', $value);

        Assert::isMap($value);
        $this->addToAssertionCount(1);
    }

    // /**
    //  * @test
    //  * @dataProvider isNonEmptyMapProvider
    //  */
    // public function isNonEmptyMap($value, $pass = true)
    // {
    //     (! $pass) && $this->invalidAssertion('isNonEmptyMap', $value);

    //     Assert::isNonEmptyMap($value);
    //     $this->addToAssertionCount(1);
    // }

    /**
     * @test
     * @dataProvider countProvider
     */
    public function testCount($expected, $value, $pass = true)
    {
        (! $pass) && $this->invalidAssertion('count', $value, $expected);

        Assert::count($value, $expected);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider maxCountProvider
     */
    public function maxCount($expected, $value, $pass = true)
    {
        (! $pass) && $this->invalidAssertion('maxCount', $value, $expected);

        Assert::maxCount($value, $expected);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider minCountProvider
     */
    public function minCount($expected, $value, $pass = true)
    {
        (! $pass) && $this->invalidAssertion('minCount', $value, $expected);

        Assert::minCount($value, $expected);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider countBetweenProvider
     */
    public function countBetween($min, $max, $value, $pass = true)
    {
        (! $pass) && $this->invalidAssertion('countBetween', $value, $min, $max);

        Assert::countBetween($value, $min, $max);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider validArrayKeyProvider
     */
    public function validArrayKey($value, $pass = true)
    {
        (! $pass) && $this->invalidAssertion('validArrayKey', $value);

        Assert::validArrayKey($value);
        $this->addToAssertionCount(1);
    }
}
