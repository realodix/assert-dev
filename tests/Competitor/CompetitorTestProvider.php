<?php

namespace Realodix\Assert\Tests\Competitor;

trait CompetitorTestProvider
{
    public function scalarProvider()
    {
        return [
            ['bool', true],
            ['bool', false],
            ['true', true],
            ['false', false],
        ];
    }
}
