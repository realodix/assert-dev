<?php

namespace Realodix\Assert\Tests;

trait HelperTestProvider
{
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
