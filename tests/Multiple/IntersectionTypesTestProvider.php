<?php

namespace Realodix\Assert\Tests\Multiple;

use Realodix\Assert\Tests\Fixtures\ClassAB;
use Realodix\Assert\Tests\Fixtures\ClassArrayAccessCountable;
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
            [InterfaceAB::class, new ClassAB],
            [[InterfaceA::class, InterfaceB::class], new ClassAB],
            [InterfaceArrayAccessCountable::class, new ClassArrayAccessCountable],
            [[\ArrayAccess::class, \Countable::class], new ClassArrayAccessCountable],
            // Invalid
            [\Countable::class, new \stdClass, false],
        ];
    }
}
