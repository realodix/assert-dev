<?php

namespace Realodix\Assert\Tests;

trait AssertionFormatTestProvider
{
    public function unionTypesProvider()
    {
        return [
            ['string|array', 'abc'],
            ['array|string', 'abc'],
            ['array|string|object', new \stdClass],
            ['int|float', 1],
            ['int|float', 1.0],
            // Invalid
            ['int|float', 'abc', false],
            ['array|string|int', new \stdClass, false],
        ];
    }

    public function intersectionTypesProvider()
    {
        return [
            // Array
            ['array&countable', []],
            ['array&iterable&countable', [1, 2, 3]],
            // Bool
            ['bool&true', true],
            ['bool&false', false],
            // Bool, but invalid
            ['bool&true', false, false],
            ['bool&false', true, false],
            // Object
            ['Exception&object', new \RuntimeException],
            ['object&countable', new \ArrayIterator([])],
            ['object&stdClass', new \stdClass],
            ['object&SimpleXMLElement', new \SimpleXMLElement('<foo>bar</foo>')],
            // Scalar
            ['scalar&bool&true', true],
            ['scalar&numeric&int', 123],
            ['scalar&float', 123.4],
            ['scalar&string', 'string'],
            // Scalar, but invalid
            ['scalar&bool&false', true, false],
            ['scalar&float', 123, false],
            ['scalar&int', 123.4, false],
            ['scalar&array', 'string', false],
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

            ['&int', 1],
            ['&int&numeric', 1],
            ['int&', 1],
            ['int&numeric&', 1],
            ['&int&', 1],
            ['&int&numeric&', 1],
        ];
    }

    public function duplicateSymbolsProvider()
    {
        return [
            ['scalar||float', 1],
            ['scalar|||float', 1],

            ['scalar&&float', 1],
            ['scalar&&&float', 1],
        ];
    }

    public function duplicateTypeNamesProvider()
    {
        return [
            ['bool|bool', true],
            ['bool|string|bool', true],

            ['int&int', 1],
            ['int&numeric&int', 1],
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
