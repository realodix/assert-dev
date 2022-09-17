<?php

namespace Realodix\Assert\Tests\Multiple;

use Realodix\Assert\Tests\Fixtures\AB;
use Realodix\Assert\Tests\Fixtures\InterfaceA;

trait UnionTypesTestProvider
{
    public function validTypesProvider()
    {
        return [
            ['string|array', 'abc'],
            ['array|string', 'abc'],
            ['array|string|object', new \stdClass],
            ['int|float', 1],
            ['int|float', 1.0],

            [['string', 'array'], 'abc'],
            [['array', 'string'], 'abc'],
            [['array', 'string'], 'object', new \stdClass],
            [['int', 'float'], 1],
            [['int', 'float'], 1.0],

            [[InterfaceA::class, \Countable::class], new AB],
        ];
    }

    public function invalidTypesProvider()
    {
        return [
            ['int|float', 'abc'],
            ['array|string|int', new \stdClass],
        ];
    }

    public function allowedSymbolProvider()
    {
        return [
            ['int ', 1],
            [' int', 1],
            ['int |string', 1],
            ['int string', 1],
            ['int^string', 1],
        ];
    }

    public function symbolsMustBeBetweenTypeNamesProvider()
    {
        return [
            ['|string', 'string'],
            ['|int|string', 'string'],
            ['string|', 'string'],
            ['string|int|', 'string'],
            ['|string|int|', 'string'],
            ['|string|int|', 'string'],
        ];
    }

    public function duplicateSymbolsProvider()
    {
        return [
            ['scalar||float', 1],
            ['scalar|||float', 1],
        ];
    }

    public function duplicateMembersProvider()
    {
        return [
            ['bool|bool', true],
            ['bool|string|bool', true],
            ['bool|boolean', true],
        ];
    }

    public function invalidTypeProvider()
    {
        return [
            // 'callback alias is not accepted' => ['callback', 'time'],
            'object is not Traversable'   => ['traversable', new \stdClass],
            'Traversable is not Iterator' => ['Iterator', new \ArrayObject],
        ];
    }
}
