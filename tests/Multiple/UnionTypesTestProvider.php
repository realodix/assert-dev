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

    public function duplicateTypesProvider()
    {
        $duplicateType = 'Duplicate type ';

        return [
            ['bool|bool', true, $duplicateType.'bool'],
            ['bool|string|bool', true, $duplicateType.'bool'],
            ['int|string|INT', 1, $duplicateType.'int'],

            ['bool|string|bool|string|int|true|INT', true, $duplicateType.'bool'],
            ['string|bool|string|int|true|INT', true, $duplicateType.'string'],
            ['bool|string|int|true|INT', true, $duplicateType.'int'],

            ['bool|boolean', true, $duplicateType.'bool'],
            ['float|double', 1.23, $duplicateType.'float'],
            ['int|integer', 123, $duplicateType.'int'],

            ['truthy-string|non-falsy-string', 'string', $duplicateType.'truthy-string'],
            ['non-falsy-string|truthy-string', 'string', $duplicateType.'truthy-string'],
        ];
    }

    public function redundantTypesProvider()
    {
        return [
            ['scalar|numeric', 123],
            ['scalar|int', 123],
            ['scalar|float', 123],
            ['scalar|string', 123],
            ['scalar|bool', 123],
            ['numeric|int', 123],
            ['numeric|float', 123],

            ['positive-int|scalar', 123],
            ['negative-int|scalar', -123],
            ['positive-int|numeric', 123],
            ['negative-int|numeric', -123],
            ['positive-int|int', 123],
            ['negative-int|int', -123],

            ['bool|true', true],
            ['bool|false', false],

            ['non-empty-string|string', 'string'],
            ['lowercase-string|string', 'string'],
            ['truthy-string|string', 'string'],
            ['non-empty-string|lowercase-string', 'string'],
            ['non-empty-string|truthy-string', 'string'],

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
