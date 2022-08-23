<?php

namespace Realodix\Assert\Tests;

trait AssertTestProvider
{
    public function isBoolProvider()
    {
        return [
            ['bool', true],
            ['bool', false],
            ['true', true],
            ['false', false],
        ];
    }

    public function validIsTypeProvider()
    {
        $staticFunction = static function () {
        };

        return [
            ['string', 'hello'],

            ['int', 1],
            ['float', 1.0],

            ['object', new \stdClass],
            ['RuntimeException', new \RuntimeException],
            ['Exception', new \RuntimeException],
            ['stdClass', new \stdClass],
            [['string', 'array', 'Closure'], $staticFunction],
            ['string|array|Closure', $staticFunction],
            [['integer', 'null'], null],

            [['null', 'callable'], 'time'],
            ['callable', 'Realodix\Assert\Assert::isType'],
            ['callable', ['Realodix\Assert\Assert', 'isType']],
            ['callable', [$this, 'validIsTypeProvider']],
            ['callable', $staticFunction],
            [['null', 'callback'], 'time'],
            ['callback', 'Realodix\Assert\Assert::isType'],
            ['callback', ['Realodix\Assert\Assert', 'isType']],
            ['callback', [$this, 'validIsTypeProvider']],
            ['callback', $staticFunction],

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
