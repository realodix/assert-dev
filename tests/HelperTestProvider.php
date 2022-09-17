<?php

namespace Realodix\Assert\Tests;

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
        ];
    }

    public function normalizeTypeProvider()
    {
        return [
            [['int'], 'integer'],
            [['int', 'int'], 'int|integer'],
            [['float', 'bool'], 'double|boolean'],
        ];
    }
}
