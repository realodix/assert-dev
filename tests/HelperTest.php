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

    public function testNormalizeType()
    {
        $actual = Helper::normalize_type(explode('|', 'int|integer'));
        $expected = ['int', 'int'];

        $this->assertSame($expected, $actual);
    }
}
