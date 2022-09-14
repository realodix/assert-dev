<?php

namespace Realodix\Assert\Tests\Multiple;

use PHPUnit\Framework\TestCase;
use Realodix\Assert\Exception\TypeErrorException;
use Realodix\Assert\Exception\UnknownClassOrInterfaceException;
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
        $this->expectExceptionMessage('Expected an ArrayAccess & Countable. Got: stdClass.');
        Type::intersection(new \stdClass, [\ArrayAccess::class, \Countable::class]);
    }

    public function testExceptionMessage2()
    {
        $this->expectExceptionMessage(
            'Expected a Realodix\Assert\Tests\Fixtures\InterfaceA & Countable. Got: stdClass.'
        );
        Type::intersection(new \stdClass, [InterfaceA::class, \Countable::class]);
    }

    public function testObjectDoesNotExist()
    {
        $this->expectException(UnknownClassOrInterfaceException::class);
        $this->expectExceptionMessage('Class or Interface does not exist.');
        Type::intersection(new AB, fooBar::class);
    }

    public function testUnsupportedMember()
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage(
            'Only support class and interface names as intersection members.'
        );

        Type::intersection(new AB, ['string', true]);
    }

    public function testDuplicateMember()
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage(
            'Duplicate type names in the same declaration is not allowed.'
        );

        Type::intersection(new AB, [InterfaceA::class, InterfaceA::class]);
    }
}
