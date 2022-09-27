<?php

namespace Realodix\Assert\Tests\Competitor;

use Realodix\Assert\Assert;
use Realodix\Assert\Tests\TestCase;
use Realodix\Assert\Type;

class CompetitorTest extends TestCase
{
    use CompetitorTestProvider;

    /**
     * @dataProvider scalarTypesProvider
     */
    public function testScalarTypes($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider compoundTypesProvider
     */
    public function testCompoundTypes($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider specialTypesProvider
     */
    public function testSpecialTypes($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider othersTypesProvider
     */
    public function testOthersTypes($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidType($value, $types);

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider allIsInstanceOfProvider
     */
    public function testAllIsInstanceOf($types, $value, $pass = true)
    {
        (! $pass) && $this->invalidElementType($value, $types);

        Type::arrayValueIs($value, $types);
        $this->addToAssertionCount(1);
    }
}
