<?php

namespace Realodix\Assert\Tests\Multiple;

use PHPUnit\Framework\TestCase;
use Realodix\Assert\Assert;
use Realodix\Assert\Exception\TypeErrorException;

class UnionTypesTest extends TestCase
{
    use UnionTypesTestProvider;

    /**
     * @dataProvider validTypesProvider
     */
    public function testValidTypes($types, $value)
    {
        Assert::type($value, $types);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider invalidTypesProvider
     */
    public function testInvalidTypes($types, $value)
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
     * @dataProvider allowedSymbolProvider
     */
    public function testAllowedSymbol($types, $value)
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage("Only '|' symbol that allowed.");
        Assert::type($value, $types);
    }

    /**
     * @dataProvider symbolsMustBeBetweenTypeNamesProvider
     */
    public function testSymbolsMustBeBetweenTypeNames($types, $value)
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('Symbols must be between type names.');
        Assert::type($value, $types);
    }

    /**
     * @dataProvider duplicateSymbolsProvider
     */
    public function testDuplicateSymbols($types, $value)
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('Duplicate symbols are not allowed.');
        Assert::type($value, $types);
    }

    /**
     * Reject duplicate type names
     *
     * Each name-resolved type may only occur once. Types like A|B|A or A&B&A
     * result in an error.
     *
     * @dataProvider duplicateTypesProvider
     */
    public function testDuplicateTypes($types, $value)
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage(
            'Duplicate type names in the same declaration is not allowed.'
        );

        if (\is_array($types)) {
            Assert::type([$value], $types);
        } else {
            Assert::type($value, $types);
        }
    }

    /**
     * @dataProvider redundantTypesProvider
     */
    public function testRedundantTypes($types, $value)
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage(
            'Duplicate type names in the same declaration is not allowed.'
        );

        if (\is_array($types)) {
            Assert::type([$value], $types);
        } else {
            Assert::type($value, $types);
        }
    }
}
