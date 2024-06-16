<?php

namespace Realodix\Assert\Tests\Competitor;

trait CompetitorTestProvider
{
    public function scalarTypesProvider()
    {
        return [
            ['scalar', true],
            ['string', 'string'],

            ['int', 1],
            ['float', 1.0],

            ['bool', true],
            ['bool', false],
            ['true', true],
            ['false', false],
        ];
    }

    public function compoundTypesProvider()
    {
        return [
            ['array', [true]],
            ['iterable', [1, 2, 3]],
            ['object', new \stdClass],
            ['callable', 'strlen'],
        ];
    }

    public function specialTypesProvider()
    {
        return [
            ['null', null],
            ['null|string', null],
            ['null|string', 'string'],
            ['resource', fopen(__FILE__, 'r')],
        ];
    }

    public function othersTypesProvider()
    {
        return [

            ['countable', [1, 2]],
            [\Exception::class, new \RuntimeException],
            ['Traversable', new \ArrayObject],

            ['list[]', ['apple', 2, 3]],
            ['non-empty-list', ['string']],

            // ArrayAccessible
            ['ArrayAccess', new \ArrayObject],
        ];
    }

    public function allIsInstanceOfProvider()
    {
        return [
            ['stdClass', [new \stdClass, new \stdClass]],
            [\stdClass::class, [new \stdClass, new \stdClass]],
            ['PDO', [new \stdClass, new \stdClass], false],
        ];
    }
}
