<?php

namespace Realodix\Assert\Tests\Multiple;

use Realodix\Assert\Tests\Fixtures\ClassAB;
use Realodix\Assert\Tests\Fixtures\InterfaceA;
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
            [[InterfaceA::class, InterfaceB::class], new ClassAB],
            // Invalid
            [\Countable::class, new \stdClass, false],
        ];
    }
}
