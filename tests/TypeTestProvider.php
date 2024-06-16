<?php

namespace Realodix\Assert\Tests;

trait TypeTestProvider
{
    public function arrayProvider()
    {
        return [
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
        ];
    }

    public function objectProvider()
    {
        return [
            ['RuntimeException', new \RuntimeException],
            [\RuntimeException::class, new \RuntimeException],
            ['Exception', new \RuntimeException],
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

            ['callable-string', 'strlen'],
            ['callable-string', 'Realodix\Assert\Assert::type'],
            ['callable-string', ['Realodix\Assert\Type', 'is'], false],
            ['callable-string', function () {}, false],

            ['resource', fopen(__FILE__, 'r')],
        ];
    }

    public function instanceofProvider()
    {
        return [
            ['ArrayAccess', new \ArrayObject],
            ['Traversable', new \ArrayObject],
            ['Traversable', new \ArrayIterator([])],
            // Invalid instanceof
            ['stdClass', new \Exception, false],
            ['stdClass', 123, false],
            ['stdClass', [], false],
            ['stdClass', null, false],
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

    public function arrayIsListProvider()
    {
        return [
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

    public function arrayIsProvider()
    {
        return [
            ['string[]', ['foo']],
            ['string[]', ['foo', 'bar']],
            ['string[]', [0 => 'foo']],
            ['string[]', 'foo', false],
            ['string[]', [1 => 'foo'], false],
            ['string[]', ['foo', 1], false],
            ['string[]', [1], false],
            ['string[]', ['key' => 'value'], false],

            ['int[]', [0]],
            ['int[]', [1, -2]],
            ['int[]', 0, false],
            ['int[]', [1 => 0], false],
            ['int[]', ['foo', 0], false],
            ['int[]', ['foo'], false],
            ['int[]', ['key' => 0], false],

            ['float[]', [1.0]],
            ['float[]', 1.0, false],

            ['bool[]', [true]],
            ['bool[]', [false]],
            // Invalid boolean
            ['bool[]', [1], false],
            ['bool[]', ['1'], false],

            ['object[]', [new \stdClass]],
            ['object[]', [new \RuntimeException]],
            ['object[]', new \stdClass, false],
        ];
    }

    public function emptyProvider()
    {
        return [
            ['empty', ''],
            ['empty', null],
            ['empty', []],
            ['empty', ['a', 'b'], false],
            ['empty', false],
            ['empty', true, false],
            ['empty', 1, false],
            ['empty', 1.0, false],
            ['empty', 0],
            ['empty', -1, false],
            ['empty', '1', false],
            ['empty', '0'],
            ['empty', '-1', false],
            ['empty', 'string', false],
            ['empty', 'true', false],
            ['empty', 'false', false],

            ['not-empty', '', false],
            ['not-empty', null, false],
            ['not-empty', [], false],
            ['not-empty', ['a', 'b']],
            ['not-empty', false, false],
            ['not-empty', true],
            ['not-empty', 1],
            ['not-empty', 1.0],
            ['not-empty', 0, false],
            ['not-empty', -1],
            ['not-empty', '1'],
            ['not-empty', '0', false],
            ['not-empty', '-1'],
            ['not-empty', 'string'],
            ['not-empty', 'true'],
            ['not-empty', 'false'],
        ];
    }

    public function nonEmptyProvider()
    {
        return [
            ['non-empty-array', ['string']],
            ['non-empty-array', '', false],
            ['non-empty-array', [''], false],
            ['non-empty-array', [null], false],
            ['non-empty-array', [0], false],
            ['non-empty-array', [0.0], false],
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

    public function elementProvider()
    {
        return [
            // beberlei/assert/allIsInstanceOf
            // Assert::allIsInstanceOf
            ['stdClass', [new \stdClass, new \stdClass]],
            [\stdClass::class, [new \stdClass, new \stdClass]],
            ['PDO', [new \stdClass, new \stdClass], false],
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
