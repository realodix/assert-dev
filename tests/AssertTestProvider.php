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

            ['countable', []],
            ['countable', [1, 2]],
            ['countable', new \ArrayIterator([])],
            ['countable', new \SimpleXMLElement('<foo>bar</foo>')],

            ['iterable', [1, 2, 3]],
            ['iterable', new \ArrayIterator([1, 2, 3])],
            ['iterable', (function () { yield 1; })()],
        ];
    }

    public function numberProvider()
    {
        return [
            ['int', 0],
            ['int', 1],

            ['float|double', 0.1],
            ['float|double', 1.0],
            ['float|double', 2.3],
            ['float|double', 1 / 3],
            ['float|double', 1 - 2 / 3],
            ['float|double', log(0)],

            ['numeric', '42'],
            ['numeric', 1337],
            ['numeric', 0x539],
            ['numeric', 02471],
            ['numeric', 0b10100111001],
            ['numeric', 1337e0],
            ['numeric', '02471'],
            ['numeric', '1337e0'],
            ['numeric', 9.1],
        ];
    }

    public function objectProvider()
    {
        return [
            ['object', new \stdClass],
            ['object', new \RuntimeException],

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
            [['string', 'array', 'Closure'], $staticFunction],
            ['string|array|Closure', $staticFunction],
            [['integer', 'null'], null],

            [['null', 'callable'], 'time'],
            [['null', 'callback'], 'time'],

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
