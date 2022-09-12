<?php

namespace Realodix\Assert\Tests\Multiple;

use Realodix\Assert\Tests\Fixtures\A;
use Realodix\Assert\Tests\Fixtures\AB;
use Realodix\Assert\Tests\Fixtures\ArrayAccessCountable;
use Realodix\Assert\Tests\Fixtures\B;
use Realodix\Assert\Tests\Fixtures\InterfaceA;
use Realodix\Assert\Tests\Fixtures\InterfaceAB;
use Realodix\Assert\Tests\Fixtures\InterfaceArrayAccessCountable;
use Realodix\Assert\Tests\Fixtures\InterfaceB;
use Realodix\Relax\RuleSet\RuleSetInterface;
use Realodix\Relax\RuleSet\Sets\Realodix;

trait IntersectionTypesTestProvider
{
    public function intersectionTypesProvider()
    {
        return [
            [RuleSetInterface::class, new Realodix],
            [[RuleSetInterface::class], new Realodix],
            [A::class, new B],
            [[InterfaceAB::class], new AB],
            [[InterfaceA::class, InterfaceB::class], new AB],
            [InterfaceArrayAccessCountable::class, new ArrayAccessCountable],
            [[\ArrayAccess::class, \Countable::class], new ArrayAccessCountable],
        ];
    }

    public function invalidIntersectionTypesProvider()
    {
        return [
            [[InterfaceA::class, \Countable::class], new AB],
            [\Countable::class, new \stdClass],
            [[\Countable::class], new \stdClass],
            [[\ArrayAccess::class, \Countable::class], new \stdClass],
        ];
    }
}
