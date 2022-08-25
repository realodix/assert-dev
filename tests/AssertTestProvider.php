<?php

namespace Realodix\Assert\Tests;

trait AssertTestProvider
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

            ['float|double', 0.1],
            ['float|double', 1.0],
            ['float|double', 2.3],
            ['float|double', 1 / 3],
            ['float|double', 1 - 2 / 3],
            ['float|double', log(0)],
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
            ['object', new \stdClass],
            ['object', new \RuntimeException],
            // Invalid object
            ['object', null, false],
            ['object', true, false],
            ['object', 1, false],
            ['object', array(), false],

            ['callable', 'strlen'],
            ['callable', 'Realodix\Assert\Assert::isType'],
            ['callable', ['Realodix\Assert\Assert', 'isType']],
            ['callable', function () {}],
            ['callable', static function () {}],

            ['resource', fopen(__FILE__, 'r')],
        ];
    }

    public function isBoolProvider()
    {
        return [
            ['bool', true],
            ['bool', false],
            ['true', true],
            ['false', false],
        ];
    }

    public function isScalarProvider()
    {
        return [
            ['scalar', '1'],
            ['scalar', 123],
            ['scalar', true],
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

    public function validIsTypeProvider()
    {
        $staticFunction = static function () {
        };

        return [
            ['RuntimeException', new \RuntimeException],
            ['Exception', new \RuntimeException],
            ['stdClass', new \stdClass],
            ['string|array|Closure', $staticFunction],

            ['Traversable', new \ArrayObject],
            ['Traversable', new \ArrayIterator([])],

            ['ArrayAccess', new \ArrayObject],
        ];
    }

    public function invalidIsTypeProvider()
    {
        return [
            // 'bool shortcut is not accepted'  => ['bool', true],
            // 'int shortcut is not accepted'   => ['int', 1],
            // 'float alias is not accepted'    => ['float', 1.0],
            // 'callback alias is not accepted' => ['callback', 'time'],

            'simple'                    => ['string', 5],
            'integer is not boolean'    => ['boolean', 1],
            'string is not boolean'     => ['boolean', '0'],
            'boolean is not integer'    => ['integer', true],
            'false is not true'         => ['true', false],
            'true is not false'         => ['false', true],
            'string is not integer'     => ['integer', '0'],
            'double is not integer'     => ['integer', 1.0],
            'integer is not double'     => ['double', 1],
            'class'                     => ['RuntimeException', new \LogicException],
            'stdClass is no superclass' => ['stdClass', new \LogicException],
            'multi'                     => ['string|integer|Closure', []],
            'null'                      => ['integer|string', null],

            'callable'               => ['null|callable', []],
            'callable is no Closure' => ['Closure', 'time'],
            'object is not callable' => ['callable', new \stdClass],

            'object is not Traversable'   => ['traversable', new \stdClass],
            'Traversable is not Iterator' => ['Iterator', new \ArrayObject],
        ];
    }
}
