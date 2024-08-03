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
use Realodix\Relax\RuleSet\Sets\Relax;

trait IntersectionTypesTestProvider
{
    public function intersectionTypesProvider()
    {
        return [
            [new Relax, RuleSetInterface::class],
            [new Relax, [RuleSetInterface::class]],
            [new B, A::class],
            [new AB, [InterfaceAB::class]],
            [new AB, [InterfaceA::class, InterfaceB::class]],
            [new ArrayAccessCountable, InterfaceArrayAccessCountable::class],
            [new ArrayAccessCountable, [\ArrayAccess::class, \Countable::class]],
        ];
    }

    public function invalidIntersectionTypesProvider()
    {
        return [
            [new AB, [InterfaceA::class, \Countable::class]],
            [new \stdClass, \Countable::class],
            [new \stdClass, [\Countable::class]],
            [new \stdClass, [\ArrayAccess::class, \Countable::class]],
        ];
    }

    public function duplicateMemberProvider()
    {
        return [
            [new AB, [InterfaceA::class, InterfaceA::class]],
            [new AB, [InterfaceA::class, Interfacea::class]],
        ];
    }
}
