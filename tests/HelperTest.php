<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Helper;

class HelperTest extends TestCase
{
    use HelperTestProvider;

    /**
     * @dataProvider duplicateProvider
     */
    public function testTypeHasDuplicateMember($types)
    {
        $types = explode('|', $types);

        $this->assertTrue(
            Helper::type_has_duplicate($types)
        );
    }

    /**
     * @dataProvider normalizeTypeProvider
     */
    public function testNormalizeType($expected, $actual)
    {
        $this->assertSame(
            $expected,
            Helper::normalize_type(explode('|', $actual))
        );
    }
}
