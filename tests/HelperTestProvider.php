<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Tests\Fixtures\InterfaceA;

trait HelperTestProvider
{
    public function duplicateProvider()
    {
        return [
            ['scalar|numeric'],
            ['scalar|int'],
            ['scalar|float'],
            ['scalar|string'],
            ['scalar|bool'],
            ['numeric|int'],
            ['numeric|float'],

            ['bool|bool'],
            ['bool|string|bool'],

            ['bool|boolean'],
            ['float|double'],
            ['int|integer'],

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
