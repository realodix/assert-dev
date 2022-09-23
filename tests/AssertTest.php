<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Assert;

class AssertTest extends TestCase
{
    /** @test */
    public function keyExists()
    {
        $value = ['first' => 1, 'second' => 4];
        $key = 'first';

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
}
