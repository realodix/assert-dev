<?php

namespace Realodix\Assert\Tests\Multiple;

use Realodix\Assert\Exception\FatalErrorException;
use Realodix\Assert\Exception\TypeErrorException;
use Realodix\Assert\Tests\Fixtures\ClassAB;
use Realodix\Assert\Tests\Fixtures\Interface\A;
use Realodix\Assert\Tests\TestCase;
use Realodix\Assert\Type;

class IntersectionTypesTest extends TestCase
{
    use IntersectionTypesTestProvider;

    /**
     * @dataProvider intersectionTypesProvider
     */
    public function testIntersectionTypes($type, $value)
    {
        Type::intersection($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider invalidIntersectionTypesProvider
     */
    public function testInvalidIntersectionTypes($type, $value)
    {
        $this->expectException(TypeErrorException::class);
        Type::intersection($type, $value);
    }

    public function testIntersectionTypesWithObjectDoesNotExist()
    {
        $this->expectException(FatalErrorException::class);
        $this->expectExceptionMessage(
            'Class or interface does not exist.'
        );

        Type::intersection(fooBar::class, new ClassAB);
    }

    public function testIntersectionTypesWithUnsupportedMember()
    {
        $this->expectException(FatalErrorException::class);
        $this->expectExceptionMessage(
            'Intersection Types only support class and interface names as intersection members.'
        );

        Type::intersection(['string', true], new ClassAB);
    }

    public function testIntersectionTypesWithDuplicateMember()
    {
        $this->expectException(FatalErrorException::class);
        $this->expectExceptionMessage(
            'Duplicate type names in the same declaration is not allowed.'
        );

        Type::intersection([A::class, A::class], new ClassAB);
    }
}
