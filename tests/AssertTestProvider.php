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

    public function isNonEmptyMapProvider()
    {
        return [
            [['string' => true]],

            [['string' => 0], false],
            [['string' => ''], false],
        ];
    }

    public function countProvider()
    {
        return [
            [1, ['foo' => 'bar']],
            [2, ['foo' => 'bar', 'baz']],

            [2, ['foo' => 'bar'], false],
        ];
    }

    public function maxCountProvider()
    {
        return [
            [1, ['foo' => 'bar']],
            [2, ['foo', 'bar']],

            [2, ['foo', 'bar', 'baz'], false],
        ];
    }

    public function minCountProvider()
    {
        return [
            [1, ['foo' => 'bar']],
            [2, ['foo', 'bar']],

            [2, ['foo'], false],
        ];
    }

    public function countBetweenProvider()
    {
        return [
            [1, 3, ['foo', 'bar', 'baz']],
            [2, 4, ['foo', 'bar', 'baz']],

            [4, 5, ['foo', 'bar', 'baz'], false],
        ];
    }

    public function validArrayKeyProvider()
    {
        return [
            [1],
            ['string'],

            [[1], false],
        ];
    }
}
