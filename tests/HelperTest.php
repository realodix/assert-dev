<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Type;

class HelperTest extends TestCase
{
    use HelperTestProvider;

    /**
     * @dataProvider duplicateProvider
     */
    public function testTypeHasDuplicateMember($types)
    {
        $types = Type::normalize_type($types);

        $this->assertTrue(
            Type::type_has_duplicate($types)
        );
    }

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
