<?php

namespace Realodix\Assert\Tests;

use Realodix\Assert\Assert;
use Realodix\Assert\Exception\FatalErrorException;

class TypeWithIntersectionTest extends TestCase
{
    use TypeWithUnionTestProvider;

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
     * @dataProvider allowedSymbolProvider
     */
    public function testAllowedSymbol($type, $value)
    {
        $this->expectException(FatalErrorException::class);
        $this->expectExceptionMessage("Only '|' symbol that allowed.");
        Assert::type($type, $value);
    }

    /**
     * @dataProvider symbolsMustBeBetweenTypeNamesProvider
     */
    public function testSymbolsMustBeBetweenTypeNames($type, $value)
    {
        $this->expectException(FatalErrorException::class);
        $this->expectExceptionMessage('Symbols must be between type names.');
        Assert::type($type, $value);
    }

    /**
     * @dataProvider duplicateSymbolsProvider
     */
    public function testDuplicateSymbols($type, $value)
    {
        $this->expectException(FatalErrorException::class);
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
        $this->expectException(FatalErrorException::class);
        $this->expectExceptionMessage(
            'Duplicate type names in the same declaration is not allowed.'
        );
        Assert::type($type, $value);
    }
}
