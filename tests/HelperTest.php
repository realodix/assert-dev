<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Type;

class HelperTest extends TestCase
{
    use HelperTestProvider;

    /**
     * @dataProvider normalizeTypeProvider
     */
    public function testNormalizeType($expected, $actual)
    {
        $this->assertSame(
            $expected,
            Type::normalize_type($actual)
        );
    }
}
