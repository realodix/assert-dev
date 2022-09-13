<?php

namespace Realodix\Assert\Tests\Multiple;

use PHPUnit\Framework\TestCase;
use Realodix\Assert\Exception\ErrorException;
use Realodix\Assert\Exception\TypeErrorException;
use Realodix\Assert\Tests\Fixtures\AB;
use Realodix\Assert\Tests\Fixtures\InterfaceA;
use Realodix\Assert\Type;

class IntersectionTypesTest extends TestCase
{
    use IntersectionTypesTestProvider;

    /**
     * @dataProvider intersectionTypesProvider
     */
    public function testValidTypes($value, $types)
    {
        Type::intersection($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider invalidIntersectionTypesProvider
     */
    public function testInvalidTypes($value, $types)
    {
        $this->expectException(TypeErrorException::class);
        Type::intersection($value, $types);
    }

    public function testExceptionMessage()
    {
        $this->expectExceptionMessage('Expected an ArrayAccess & Countable. Got: object.');
        Type::intersection([\ArrayAccess::class, \Countable::class], new \stdClass);
    }

    public function testObjectDoesNotExist()
    {
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage(
            'Class or Interface does not exist.'
        );

        Type::intersection(fooBar::class, new AB);
    }

    public function testUnsupportedMember()
    {
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage(
            'Intersection Types only support class and Interface names as intersection members.'
        );

        Type::intersection(['string', true], new AB);
    }

    public function testDuplicateMember()
    {
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage(
            'Duplicate type names in the same declaration is not allowed.'
        );

        Type::intersection([InterfaceA::class, InterfaceA::class], new AB);
    }
}
