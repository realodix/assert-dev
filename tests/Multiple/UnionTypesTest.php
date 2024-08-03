<?php

namespace Realodix\Assert\Tests\Multiple;

use Realodix\Assert\Assert;
use Realodix\Assert\Exception\TypeErrorException;
use Realodix\Assert\Tests\TestCase;

class UnionTypesTest extends TestCase
{
    use UnionTypesTestProvider;

    /**
     * @test
     * @dataProvider validTypesProvider
     */
    public function validTypes($types, $value)
    {
        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider validTypesProvider
     */
    public function validTypesInputArray($types, $value)
    {
        if (\is_string($types)) {
            $types = $this->stringToArray($types);
        }

        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     * @dataProvider invalidTypesProvider
     */
    public function invalidTypeInputArray($types, $value)
    {
        if (\is_string($types)) {
            $types = $this->stringToArray($types);
        }

        $this->expectException(TypeErrorException::class);
        Assert::type($value, $types);
    }

    /**
     * @test
     * @dataProvider invalidTypesProvider
     */
    public function invalidType($types, $value)
    {
        $this->expectException(TypeErrorException::class);
        Assert::type($value, $types);
    }

    public function testExceptionMessage()
    {
        $this->expectExceptionMessage('Expected an array|string. Got: int.');
        Assert::type(1, 'array|string');
    }

    /**
     * @test
     * @dataProvider allowedSymbolProvider
     */
    public function allowedSymbol($types, $value)
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage("Only '|' symbol that allowed.");
        Assert::type($value, $types);
    }

    /**
     * @test
     * @dataProvider symbolsMustBeBetweenTypeNamesProvider
     */
    public function symbolsMustBeBetweenTypeNames($types, $value)
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('Symbols must be between type names.');
        Assert::type($value, $types);
    }

    /**
     * @test
     * @dataProvider duplicateSymbolsProvider
     */
    public function duplicateSymbols($types, $value)
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('Duplicate symbols are not allowed.');
        Assert::type($value, $types);
    }

    /**
     * @test
     * @dataProvider duplicateTypesProvider
     */
    public function duplicateTypes($types, $value, $message)
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage($message);

        Assert::type($value, $types);
    }

    /**
     * @test
     * @dataProvider duplicateTypesProvider
     */
    public function duplicateTypesWithTypeInputAsAnArray($types, $value, $message)
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage($message);

        $types = explode('|', $types);
        Assert::type($value, $types);
    }

    /**
     * @test
     * @dataProvider redundantTypesProvider
     */
    public function redundantTypes($types, $value)
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage(
            'Union type declarations contain redundant types.',
        );

        Assert::type($value, $types);
    }

    /**
     * @test
     * @dataProvider redundantTypesProvider
     */
    public function redundantTypesWithTypeInputAsAnArray($types, $value)
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage(
            'Union type declarations contain redundant types.',
        );

        $types = explode('|', $types);
        Assert::type($value, $types);
    }
}
