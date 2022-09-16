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
}
