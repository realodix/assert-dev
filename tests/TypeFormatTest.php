<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Assert;
use Realodix\Assert\Exception\InvalidTypeDeclarationFormatException;

class TypeFormatTest extends TestCase
{
    use TypeFormatTestProvider;

    /**
     * @dataProvider unionTypesProvider
     */
    public function testUnionTypes($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Assert::type($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider intersectionTypesProvider
     */
    public function testIntersectionTypes($type, $value, $pass = true)
    {
        if (! $pass) {
            $this->expectException(InvalidTypeDeclarationFormatException::class);
            $this->expectExceptionMessage(
                'Intersection Types only support class and interface names as intersection members.'
            );
        }

        Assert::type($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider allowedSymbolProvider
     */
    public function testAllowedSymbol($type, $value)
    {
        $this->expectException(InvalidTypeDeclarationFormatException::class);
        $this->expectExceptionMessage("Only '|' symbol that allowed.");
        Assert::type($type, $value);
    }

    /**
     * @dataProvider symbolsMustBeBetweenTypeNamesProvider
     */
    public function testSymbolsMustBeBetweenTypeNames($type, $value)
    {
        $this->expectException(InvalidTypeDeclarationFormatException::class);
        $this->expectExceptionMessage('Symbols must be between type names.');
        Assert::type($type, $value);
    }

    /**
     * @dataProvider duplicateSymbolsProvider
     */
    public function testDuplicateSymbols($type, $value)
    {
        $this->expectException(InvalidTypeDeclarationFormatException::class);
        $this->expectExceptionMessage('Duplicate symbols are not allowed.');
        Assert::type($type, $value);
    }

    /**
     * Intersection Types is called "pure" Intersection Types because combining Union
     * Types and Intersection Types in the same declaration is not allowed.
     */
    public function testPureIntersectionTypes()
    {
        $this->expectException(InvalidTypeDeclarationFormatException::class);
        $this->expectExceptionMessage(
            "Combining '|' and '&' in the same declaration is not allowed."
        );
        Assert::type('numeric&int|string', 1);
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
        $this->expectException(InvalidTypeDeclarationFormatException::class);
        $this->expectExceptionMessage(
            'Duplicate type names in the same declaration is not allowed.'
        );
        Assert::type($type, $value);
    }
}
