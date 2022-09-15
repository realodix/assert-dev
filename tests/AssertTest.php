<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Assert;

class AssertTest extends TestCase
{
    /**
     * @test
     */
    public function keyExists()
    {
        $value = ['first' => 1, 'second' => 4];
        $key = 'first';

        Assert::keyExists($value, $key);
        $this->addToAssertionCount(1);
    }
}
