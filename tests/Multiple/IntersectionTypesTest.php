<?php

namespace Realodix\Assert\Tests\Multiple;

use Realodix\Assert\Exception\FatalErrorException;
use Realodix\Assert\Tests\Fixtures\ClassAB;
use Realodix\Assert\Tests\Fixtures\InterfaceA;
use Realodix\Assert\Tests\TestCase;
use Realodix\Assert\Type;

class IntersectionTypesTest extends TestCase
{
    use IntersectionTypesTestProvider;

    /**
     * @dataProvider intersectionTypesProvider
     */
    public function testIntersectionTypes($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Type::intersection($type, $value);
        $this->addToAssertionCount(1);
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

        Type::intersection([InterfaceA::class, InterfaceA::class], new ClassAB);
    }
}
