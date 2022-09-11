<?php

namespace Realodix\Assert\Tests\Multiple;

use Realodix\Assert\Tests\Fixtures\ClassA;
use Realodix\Assert\Tests\Fixtures\ClassAB;
use Realodix\Assert\Tests\Fixtures\ClassArrayAccessCountable;
use Realodix\Assert\Tests\Fixtures\ClassB;
use Realodix\Assert\Tests\Fixtures\Interface\A;
use Realodix\Assert\Tests\Fixtures\Interface\AB;
use Realodix\Assert\Tests\Fixtures\Interface\ArrayAccessCountable;
use Realodix\Assert\Tests\Fixtures\Interface\B;
use Realodix\Relax\RuleSet\RuleSetInterface;
use Realodix\Relax\RuleSet\Sets\Realodix;

trait IntersectionTypesTestProvider
{
    public function intersectionTypesProvider()
    {
        return [
            [RuleSetInterface::class, new Realodix],
            [[RuleSetInterface::class], new Realodix],
            [ClassA::class, new ClassB],
            [[AB::class], new ClassAB],
            [[A::class, B::class], new ClassAB],
            [ArrayAccessCountable::class, new ClassArrayAccessCountable],
            [[\ArrayAccess::class, \Countable::class], new ClassArrayAccessCountable],
        ];
    }

    public function invalidIntersectionTypesProvider()
    {
        return [
            [\Countable::class, new \stdClass, false],
        ];
    }
}
