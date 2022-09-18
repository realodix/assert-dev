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

    public function string_provider()
    {
        return [
            ['abc'],
            ['23'],
            ['23.5'],
            [''],
            [' '],
            ['0'],
            [[], false],
            [1, false],
            [1.1, false],
            [0x10, false],
            [0b10, false],
            [null, false],
            [true, false],
        ];
    }

    public function int_provider()
    {
        return [
            [0],
            [1],
            [-1],
            // Invalid int
            ['123', false],
            [1.0, false],
            [1.23, false],
            [true, false],
        ];
    }

    public function float_provider()
    {
        return [
            [0.1],
            [1.0],
            [2.3],
            [1 / 3],
            [1 - 2 / 3],
            [log(0)],
            // Invalid float
            [1, false],
            [false, false],
            ['test', false],
            [null, false],
            ['1.23', false],
            ['10', false],
        ];
    }

    public function arrayWithVariantProvider()
    {
        return [
            ['bool[]', [true]],
            ['bool[]', [false]],
            // Invalid boolean
            ['bool[]', [1], false],
            ['bool[]', ['1'], false],

            ['object[]', []],
            ['object[]', [new \stdClass]],
            ['object[]', [1], false],
        ];
    }
}
