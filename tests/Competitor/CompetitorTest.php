<?php

namespace Realodix\Assert\Tests\Competitor;

use Realodix\Assert\Assert;
use Realodix\Assert\Tests\TestCase;

class CompetitorTest extends TestCase
{
    use CompetitorTestProvider;

    /**
     * @dataProvider scalarProvider
     */
    public function testScalar($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }
}
