<?php

namespace Realodix\Assert\Tests\Multiple;

use Realodix\Assert\Assert;
use Realodix\Assert\Exception\FatalErrorException;
use Realodix\Assert\Tests\Fixtures\ClassAB;
use Realodix\Assert\Tests\Fixtures\InterfaceA;
use Realodix\Assert\Tests\TestCase;

class IntersectionTypesTest extends TestCase
{
    use IntersectionTypesTestProvider;

    /**
     * @dataProvider intersectionTypesProvider
     */
    public function testIntersectionTypes($type, $value)
    {
        Assert::type($type, $value, '', true);
        $this->addToAssertionCount(1);
    }

    public function testIntersectionTypesWithObjectDoesNotExist()
    {
        $this->expectException(FatalErrorException::class);
        $this->expectExceptionMessage(
            'Class or interface does not exist.'
        );

        Assert::type(fooBar::class, new ClassAB, '', true);
    }

    public function testIntersectionTypesWithUnsupportedMember()
    {
        $this->expectException(FatalErrorException::class);
        $this->expectExceptionMessage(
            'Intersection Types only support class and interface names as intersection members.'
        );

        Assert::type(['string', true], new ClassAB, '', true);
    }

    public function testIntersectionTypesWithDuplicateMember()
    {
        $this->expectException(FatalErrorException::class);
        $this->expectExceptionMessage(
            'Duplicate type names in the same declaration is not allowed.'
        );

        Assert::type([InterfaceA::class, InterfaceA::class], new ClassAB, '', true);
    }
}
