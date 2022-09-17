<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Tests\Fixtures\InterfaceA;

trait HelperTestProvider
{
    public function duplicateProvider()
    {
        return [
            [['numeric', 'int']],
            [[InterfaceA::class, InterfaceA::class]],
        ];
    }

    public function normalizeTypeProvider()
    {
        return [
            [['int'], 'integer'],
            [['int', 'int'], 'int|integer'],
            [['float', 'bool'], 'double|boolean'],
            [['float', 'float'], 'float|double'],
        ];
    }
}
