<?php

namespace Realodix\Assert\Tests;

trait AssertTestProvider
{
    public function keyExistsProvider()
    {
        return [
            ['first', ['first' => 1, 'second' => 4]],

            ['string', ['first' => 1, 'second' => 4], false],
        ];
    }

    public function keyNotExistsProvider()
    {
        return [
            ['string', ['first' => 1, 'second' => 4]],

            ['first', ['first' => 1, 'second' => 4], false],
        ];
    }

    public function isMapProvider()
    {
        return [
            [['string' => true]],

            [[true], false],
        ];
    }
}
