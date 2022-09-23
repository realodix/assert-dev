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
     * @test
     * @dataProvider intersectionTypesProvider
     */
    public function validTypes($value, $types)
    {
        Type::intersection($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider invalidIntersectionTypesProvider
     */
    public function invalidTypes($value, $types)
    {
        $this->expectException(TypeErrorException::class);
        Type::intersection($value, $types);
    }

    /** @test */
    public function exceptionMessage()
    {
        $this->expectExceptionMessage('Expected an ArrayAccess & Countable. Got: stdClass.');
        Type::intersection(new \stdClass, [\ArrayAccess::class, \Countable::class]);
    }

    /** @test */
    public function exceptionMessage2()
    {
        $this->expectExceptionMessage(
            'Expected a Realodix\Assert\Tests\Fixtures\InterfaceA & Countable. Got: stdClass.'
        );
        Type::intersection(new \stdClass, [InterfaceA::class, \Countable::class]);
    }

    /** @test */
    public function objectDoesNotExist()
    {
        $this->expectException(UnknownClassOrInterfaceException::class);
        $this->expectExceptionMessage('Class or Interface does not exist.');
        Type::intersection(new AB, fooBar::class);
    }

    /** @test */
    public function unsupportedMember()
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage(
            'Only class and interface can be part of an intersection type.'
        );

        Type::intersection(new AB, ['string', true]);
    }

    /** @test */
    public function duplicateMember()
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage(
            'Duplicate type names in the same declaration is not allowed.'
        );

        Type::intersection(new AB, [InterfaceA::class, InterfaceA::class]);
    }
}
