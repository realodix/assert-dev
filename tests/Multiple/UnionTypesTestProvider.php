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
            // ['int|string|INT', 1],

            ['bool|boolean', true],
            ['float|double', 1.23],
            ['int|integer', 123],

            ['scalar|numeric', 123],
            ['scalar|int', 123],
            ['scalar|float', 123],
            ['scalar|string', 123],
            ['scalar|bool', 123],
            ['bool|true', true],
            ['bool|false', false],
            ['numeric|int', 123],
            ['numeric|float', 123],

            ['string|non-empty-string', 'string'],
        ];
    }

    public function duplicateMembersWithArrayInputProvider()
    {
        return [
            ['array|bool[]', []],
            ['array|string[]', []],
            ['array|int[]', []],
            ['array|float[]', []],
            ['array|object[]', []],
            ['array|list[]', []],
            ['array|non-empty-array', ['string']],
            ['array|non-empty-list', ['string']],
            ['non-empty-array|list[]', ['string']],
            ['non-empty-array|non-empty-list', ['string']],
            ['non-empty-list|list[]', ['string']],
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
