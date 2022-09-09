<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Tests\Fixtures\ClassAB;
use Realodix\Assert\Tests\Fixtures\InterfaceA;
use Realodix\Assert\Tests\Fixtures\InterfaceB;
use Realodix\Relax\RuleSet\RuleSetInterface;
use Realodix\Relax\RuleSet\Sets\Realodix;

trait TypeWithIntersectionTestProvider
{
    public function intersectionTypesProvider()
    {
        return [
            [RuleSetInterface::class, new Realodix],
            [[RuleSetInterface::class], new Realodix],
            [[InterfaceA::class, InterfaceB::class], new ClassAB],
        ];
    }
}
