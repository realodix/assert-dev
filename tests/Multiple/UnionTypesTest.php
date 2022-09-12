<?php

namespace Realodix\Assert\Tests\Multiple;

use PHPUnit\Framework\TestCase;
use Realodix\Assert\Assert;
use Realodix\Assert\Exception\ErrorException;
use Realodix\Assert\Exception\TypeErrorException;

class UnionTypesTest extends TestCase
{
    use UnionTypesTestProvider;

    /**
     * @dataProvider validTypesProvider
     */
    public function testValidTypes($type, $value)
    {
        Assert::type($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider invalidTypesProvider
     */
    public function testInvalidTypes($type, $value)
    {
        $this->expectException(TypeErrorException::class);
        Assert::type($type, $value);
    }

    public function testExceptionMessage()
    {
        $this->expectExceptionMessage('Expected an array|string. Got: integer.');
        Assert::type('array|string', 1);
    }

    /**
     * @dataProvider allowedSymbolProvider
     */
    public function testAllowedSymbol($type, $value)
    {
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage("Only '|' symbol that allowed.");
        Assert::type($type, $value);
    }

    /**
     * @dataProvider symbolsMustBeBetweenTypeNamesProvider
     */
    public function testSymbolsMustBeBetweenTypeNames($type, $value)
    {
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage('Symbols must be between type names.');
        Assert::type($type, $value);
    }

    /**
     * @dataProvider duplicateSymbolsProvider
     */
    public function testDuplicateSymbols($type, $value)
    {
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage('Duplicate symbols are not allowed.');
        Assert::type($type, $value);
    }

    /**
     * Reject duplicate type names
     *
     * Each name-resolved type may only occur once. Types like A|B|A or A&B&A
     * result in an error.
     *
     * @dataProvider duplicateTypeNamesProvider
     */
    public function testDuplicateTypeNames($type, $value)
    {
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage(
            'Duplicate type names in the same declaration is not allowed.'
        );
        Assert::type($type, $value);
    }
}
