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

    // public function isNonEmptyMapProvider()
    // {
    //     return [
    //         [['string' => true]],

    //         [['string' => 0], false],
    //     ];
    // }

    public function countProvider()
    {
        return [
            [1, ['foo' => 'bar']],
            [2, ['foo' => 'bar', 'baz']],

            [2, ['foo' => 'bar'], false],
        ];
    }
}
