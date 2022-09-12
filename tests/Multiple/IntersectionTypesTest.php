<?php

namespace Realodix\Assert\Tests\Multiple;

use Realodix\Assert\Exception\ErrorException;
use Realodix\Assert\Tests\Fixtures\ClassAB;
use Realodix\Assert\Tests\Fixtures\Interface\A;
use Realodix\Assert\Tests\TestCase;
use Realodix\Assert\Type;
use Realodix\Assert\Exception\TypeErrorException;
class IntersectionTypesTest extends TestCase
{
    use IntersectionTypesTestProvider;

    /**
     * @dataProvider intersectionTypesProvider
     */
    public function testValidTypes($type, $value)
    {
        Type::intersection($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider invalidIntersectionTypesProvider
     */
    public function testInvalidTypes($type, $value)
    {
        $this->expectException(TypeErrorException::class);
        Type::intersection($type, $value);
    }

    public function testObjectDoesNotExist()
    {
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage(
            'Class or interface does not exist.'
        );

        Type::intersection(fooBar::class, new ClassAB);
    }

    public function testUnsupportedMember()
    {
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage(
            'Intersection Types only support class and interface names as intersection members.'
        );

        Type::intersection(['string', true], new ClassAB);
    }

    public function testDuplicateMember()
    {
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage(
            'Duplicate type names in the same declaration is not allowed.'
        );

        Type::intersection([A::class, A::class], new ClassAB);
    }
}
