<?php

namespace Realodix\Assert\Tests;

trait TypeTestProvider
{
    public function arrayProvider()
    {
        return [
            ['ArrayAccess', new \ArrayObject],
            ['Traversable', new \ArrayObject],
            ['Traversable', new \ArrayIterator([])],

            ['array', []],
            ['array', ['this', 'is', 'an array']],
            ['array', [0 => 1]],
            ['array', [0 => null]],
            ['array', ['a', 'b' => [1, 2]]],
            // Invalid array
            ['array', new \ArrayIterator([]), false],
            ['array', 123, false],
            ['array', new \stdClass, false],

            ['countable', []],
            ['countable', [1, 2]],
            ['countable', new \ArrayIterator([])],
            ['countable', new \ArrayIterator([1, 2])],
            ['countable', new \SimpleXMLElement('<foo>bar</foo>')],
            // Invalid countable
            ['countable', new \stdClass, false],
            ['countable', 'abcd', false],
            ['countable', 123, false],

            ['iterable', [1, 2, 3]],
            ['iterable', new \ArrayIterator([1, 2, 3])],
            ['iterable', (function () { yield 1; })()],
            // Invalid iterable
            ['iterable', 123, false],
            ['iterable', new \stdClass, false],
        ];
    }

    public function numberProvider()
    {
        return [
            ['int', 0],
            ['int', 1],
            // Invalid int
            ['int', '123', false],
            ['int', 1.0, false],
            ['int', 1.23, false],
            ['int', true, false],

            ['float', 0.1],
            ['float', 1.0],
            ['float', 2.3],
            ['float', 1 / 3],
            ['float', 1 - 2 / 3],
            ['float', log(0)],
            // Invalid float
            ['float', 1, false],
            ['float', false, false],
            ['float', 'test', false],
            ['float', null, false],
            ['float', '1.23', false],
            ['float', '10', false],

            ['numeric', '42'],
            ['numeric', 1337],
            ['numeric', 0x539],
            ['numeric', 02471],
            ['numeric', 0b10100111001],
            ['numeric', 1337e0],
            ['numeric', '02471'],
            ['numeric', '1337e0'],
            ['numeric', 9.1],
            // https://php.watch/versions/7.4/underscore_numeric_separator
            ['numeric', 1_000_000], // Decimal
            ['numeric', 0.300_000_000_000_000_04], // Float
            ['numeric', 6.62_607_004e-34], // Scientific
            ['numeric', 0b1111_0000_1001_1111_1001_0010_1010_1001], // Binary
            ['numeric', 0xBEEF_BABE], // Hex
            ['numeric', 0123_7264], // Octal
            // Invalid numeric
            ['numeric', '0x539', false],
            ['numeric', '0b10100111001', false],
            ['numeric', 'not numeric', false],
            ['numeric', [], false],
            ['numeric', null, false],
            ['numeric', '', false],
        ];
    }

    public function objectProvider()
    {
        return [
            ['RuntimeException', new \RuntimeException],
            [\RuntimeException::class, new \RuntimeException],
            ['Exception', new \RuntimeException],
            [\Exception::class, new \RuntimeException],
            ['stdClass', new \stdClass],
            [\stdClass::class, new \stdClass],
            [\DateTimeInterface::class, new \DateTimeImmutable],

            ['object', new \stdClass],
            ['object', new \RuntimeException],
            // Invalid object
            ['object', null, false],
            ['object', true, false],
            ['object', 1, false],
            ['object', [], false],

            ['callable', 'strlen'],
            ['callable', 'Realodix\Assert\Assert::type'],
            ['callable', ['Realodix\Assert\Type', 'is']],
            ['callable', function () {}],
            ['callable', function (int $input): bool {return $input + ($input / 2) == 15; }],
            ['callable', static function () {}],
            // Invalid callable
            ['callable', 'foobar', false],
            ['callable', new \stdClass, false],

            ['resource', fopen(__FILE__, 'r')],
        ];
    }

    public function isBoolProvider()
    {
        return [
            ['bool', true],
            ['bool', false],
            ['boolean', true],
            ['boolean', false],
            ['true', true],
            ['false', false],
            // Invalid boolean
            ['bool', 1, false],
            ['bool', '1', false],
            ['true', false, false],
            ['false', true, false],
        ];
    }

    public function instanceofProvider()
    {
        return [
            ['stdClass', new \stdClass],
            // Invalid instanceof
            ['stdClass', new \Exception, false],
            ['stdClass', 123, false],
            ['stdClass', [], false],
            ['stdClass', null, false],
        ];
    }

    public function isScalarProvider()
    {
        return [
            // https://www.php.net/manual/en/language.types.intro.php
            ['scalar', true], // bool
            ['scalar', 123],
            ['scalar', 123.4],
            ['scalar', 'string'],
            // Invalid scalar, its compound types
            ['scalar', [], false], // array
            ['scalar', [123], false], // iterable
            ['scalar', new \stdClass, false], // object|callable
            // Invalid scalar, its two special types
            ['scalar', null, false],
        ];
    }

    public function isStringProvider()
    {
        return [
            ['string', 'abc'],
            ['string', '23'],
            ['string', '23.5'],
            ['string', ''],
            ['string', ' '],
            ['string', '0'],
        ];
    }

    public function arrayIsProvider()
    {
        return [
            ['string[]', ['string']],
            ['string[]', ['string' => 'string']],
            ['string[]', [0 => 'string']],
            ['string[]', [1 => 'string']],
            ['string[]', [1 => 'string', 0 => 'string']],
            ['string[]', [1], false],
            ['string[]', ['string', 1], false],
            ['string[]', [1, 'string'], false],
            ['string[]', [0 => 0, 1 => 1], false],
            ['string[]', [0 => 0, 1 => 'string'], false],

            ['int[]', [0]],
            ['int[]', [1]],
            ['int[]', [-1]],
            ['int[]', [1.0], false],
            ['int[]', [1.23], false],
            ['int[]', [true], false],
            ['int[]', ['123'], false],

            ['float[]', [1.0]],
            ['float[]', [1], false],
            ['float[]', [true], false],
            ['float[]', ['string'], false],
            ['float[]', [null], false],
            ['float[]', ['1.23'], false],
            ['float[]', ['10'], false],

            ['bool[]', [true]],
            ['bool[]', [false]],
            // Invalid boolean
            ['bool[]', [1], false],
            ['bool[]', ['1'], false],

            ['object[]', [new \stdClass]],
            ['object[]', [new \RuntimeException]],
            ['object[]', [null], false],
            ['object[]', [true], false],
            ['object[]', [1], false],

            ['list[]', []],
            ['list[]', ['apple', 2, 3]],
            ['list[]', [0 => 'apple', 'orange']],
            // The array does not start at 0
            ['list[]', [1 => 'apple', 'orange'], false],
            // The keys are not in the correct order
            ['list[]', [1 => 'apple', 0 => 'orange'], false],
            // Non-integer keys
            ['list[]', [0 => 'apple', 'foo' => 'bar'], false],
            // Non-consecutive keys
            ['list[]', [0 => 'apple', 2 => 'bar'], false],
        ];
    }

    public function nonEmptyProvider()
    {
        return [
            ['non-empty-string', 'string'],
            ['non-empty-string', ['string'], false],
            ['non-empty-string', '', false],
            ['non-empty-string', [''], false],
            ['non-empty-string', null, false],
            ['non-empty-string', [null], false],
            ['non-empty-string', 0, false],
            ['non-empty-string', [0], false],
            ['non-empty-string', 0.0, false],
            ['non-empty-string', [0.0], false],
            ['non-empty-string', false, false],
            ['non-empty-string', [false], false],
            ['non-empty-string', [], false],
            ['non-empty-string', [[]], false],

            ['non-empty-array', ['string']],
            ['non-empty-array', 'string', false],
            ['non-empty-array', '', false],
            ['non-empty-array', [''], false],
            ['non-empty-array', null, false],
            ['non-empty-array', [null], false],
            ['non-empty-array', 0, false],
            ['non-empty-array', [0], false],
            ['non-empty-array', 0.0, false],
            ['non-empty-array', [0.0], false],
            ['non-empty-array', false, false],
            ['non-empty-array', [false], false],
            ['non-empty-array', [], false],
            ['non-empty-array', [[]], false],

            ['non-empty-list', ['string']],
            ['non-empty-list', ['apple', 2, 3]],
            ['non-empty-list', [0 => 'apple', 'orange']],
            ['non-empty-list', [], false],
            ['non-empty-list', ['', 2, 3], false],
            ['non-empty-list', [0 => '', 'orange'], false],
            ['non-empty-list', [0 => 'apple', ''], false],
            ['non-empty-list', ['string' => 'string'], false],
        ];
    }

    public function arrayIsWithInvalidInputProvider()
    {
        return [
            ['string[]', []],

            ['string[]', ''],
            ['int[]', 1],
            ['float[]', 0.1],
            ['bool[]', true],
            ['object[]', new \stdClass],
            ['list[]', 'string'],
        ];
    }
}
