<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Type;

class AssertionFormatTest extends TestCase
{
    use AssertionFormatTestProvider;

    /**
     * @dataProvider unionTypesProvider
     */
    public function testUnionTypes($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Type::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider intersectionTypesProvider
     */
    public function testIntersectionTypes($type, $value, $pass = true)
    {
        (! $pass) && $this->testFailed($type, $value);

        Type::isType($type, $value);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider allowedSymbolProvider
     */
    public function testAllowedSymbol($type, $value)
    {
        $this->expectException(\Realodix\Assert\InvalidAssertionFormatException::class);
        $this->expectExceptionMessage("Only '|' or  '&' symbol that allowed.");
        Type::isType($type, $value);
    }

    /**
     * @dataProvider symbolsMustBeBetweenTypeNamesProvider
     */
    public function testSymbolsMustBeBetweenTypeNames($type, $value)
    {
        $this->expectException(\Realodix\Assert\InvalidAssertionFormatException::class);
        $this->expectExceptionMessage('Symbols must be between type names.');
        Type::isType($type, $value);
    }

    /**
     * @dataProvider duplicateSymbolsProvider
     */
    public function testDuplicateSymbols($type, $value)
    {
        $this->expectException(\Realodix\Assert\InvalidAssertionFormatException::class);
        $this->expectExceptionMessage('Duplicate symbols are not allowed.');
        Type::isType($type, $value);
    }

    /**
     * Intersection Types is called "pure" Intersection Types because combining Union
     * Types and Intersection Types in the same declaration is not allowed.
     */
    public function testPureIntersectionTypes()
    {
        $this->expectException(\Realodix\Assert\InvalidAssertionFormatException::class);
        $this->expectExceptionMessage(
            "Combining '|' and '&' in the same declaration is not allowed."
        );
        Type::isType('numeric&int|string', 1);
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
        $this->expectException(\Realodix\Assert\InvalidAssertionFormatException::class);
        $this->expectExceptionMessage(
            'Duplicate type names in the same declaration is not allowed.'
        );
        Type::isType($type, $value);
    }
}
