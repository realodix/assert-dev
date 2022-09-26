<?php

namespace Realodix\Assert\Tests\Competitor;

trait CompetitorTestProvider
{
    public function scalarProvider()
    {
        return [
            ['scalar', true],
            ['string', 'string'],

            ['numeric', 1],
            ['int', 1],
            ['float', 1.0],

            ['bool', true],
            ['bool', false],
            ['true', true],
            ['false', false],
        ];
    }
}
