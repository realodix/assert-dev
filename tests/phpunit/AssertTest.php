<?php

namespace Realodix\Assert\Test;

use ArrayObject;
use LogicException;
use Realodix\Assert\Assert;
use Realodix\Assert\InvariantException;
use Realodix\Assert\ParameterAssertionException;
use Realodix\Assert\ParameterElementTypeException;
use Realodix\Assert\ParameterKeyTypeException;
use Realodix\Assert\ParameterTypeException;
use Realodix\Assert\PostconditionException;
use Realodix\Assert\PreconditionException;
use Realodix\Assert\UnreachableException;
use RuntimeException;
use stdClass;

/**
 * @covers \Realodix\Assert\Assert
 */
class AssertTest extends \PHPUnit\Framework\TestCase
{
    public function testPreconditionPass()
    {
        Assert::precondition(true, 'test');
        $this->addToAssertionCount(1);
    }

    /**
     * @covers \Realodix\Assert\PreconditionException
     */
    public function testPreconditionFail()
    {
        $this->expectException(PreconditionException::class);
        Assert::precondition(false, 'test');
    }

    public function testParameterPass()
    {
        Assert::parameter(true, 'foo', 'test');
        $this->addToAssertionCount(1);
    }

    /**
     * @covers \Realodix\Assert\ParameterAssertionException
     */
    public function testParameterFail()
    {
        try {
            Assert::parameter(false, 'test', 'testing');
            $this->fail('Expected ParameterAssertionException');
        } catch (ParameterAssertionException $ex) {
            $this->assertSame('test', $ex->getParameterName());
        }
    }

    public function validParameterTypeProvider()
    {
        return [
            'simple'          => ['string', 'hello'],
            'boolean (true)'  => ['boolean', true],
            'boolean (false)' => ['boolean', false],
            'true'            => ['true', true],
            'false'           => ['false', false],
            'integer'         => ['integer', 1],
            'double'          => ['double', 1.0],
            'object'          => ['object', new stdClass],
            'class'           => ['RuntimeException', new RuntimeException],
            'subclass'        => ['Exception', new RuntimeException],
            'stdClass'        => ['stdClass', new stdClass],
            'multi'           => [['string', 'array', 'Closure'], static function () {
            }],
            'multi (old)' => ['string|array|Closure', static function () {
            }],
            'null' => [['integer', 'null'], null],

            'callable'            => [['null', 'callable'], 'time'],
            'static callable'     => ['callable', 'Realodix\Assert\Assert::parameterType'],
            'callable array'      => ['callable', ['Realodix\Assert\Assert', 'parameterType']],
            'callable $this'      => ['callable', [$this, 'validParameterTypeProvider']],
            'Closure is callable' => ['callable', static function () {
            }],

            'Traversable'       => ['Traversable', new ArrayObject],
            'Traversable array' => ['Traversable', []],
        ];
    }

    /**
     * @dataProvider validParameterTypeProvider
     */
    public function testParameterTypePass($type, $value)
    {
        Assert::parameterType($type, $value, 'test');
        $this->addToAssertionCount(1);
    }

    public function invalidParameterTypeProvider()
    {
        return [
            'bool shortcut is not accepted'  => ['bool', true],
            'int shortcut is not accepted'   => ['int', 1],
            'float alias is not accepted'    => ['float', 1.0],
            'callback alias is not accepted' => ['callback', 'time'],

            'simple'                    => ['string', 5],
            'integer is not boolean'    => ['boolean', 1],
            'string is not boolean'     => ['boolean', '0'],
            'boolean is not integer'    => ['integer', true],
            'false is not true'         => ['true', false],
            'true is not false'         => ['false', true],
            'string is not integer'     => ['integer', '0'],
            'double is not integer'     => ['integer', 1.0],
            'integer is not double'     => ['double', 1],
            'class'                     => ['RuntimeException', new LogicException],
            'stdClass is no superclass' => ['stdClass', new LogicException],
            'multi'                     => ['string|integer|Closure', []],
            'null'                      => ['integer|string', null],

            'callable'               => ['null|callable', []],
            'callable is no Closure' => ['Closure', 'time'],
            'object is not callable' => ['callable', new stdClass],

            'object is not Traversable'   => ['Traversable', new stdClass],
            'Traversable is not Iterator' => ['Iterator', new ArrayObject],
        ];
    }

    /**
     * @dataProvider invalidParameterTypeProvider
     * @covers \Realodix\Assert\ParameterTypeException
     */
    public function testParameterTypeFail($type, $value)
    {
        try {
            Assert::parameterType($type, $value, 'test');
            $this->fail('Expected ParameterTypeException');
        } catch (ParameterTypeException $ex) {
            $this->assertSame($type, $ex->getParameterType());
            $this->assertSame('test', $ex->getParameterName());
        }
    }

    /**
     * @covers \Realodix\Assert\ParameterAssertionException
     */
    public function testParameterTypeCatch()
    {
        $this->expectException(ParameterAssertionException::class);
        Assert::parameterType('string', 17, 'test');
    }

    public function validParameterKeyTypeProvider()
    {
        return [
            ['integer', []],
            ['integer', [1]],
            ['integer', [1 => 1]],
            ['integer', [1.0 => 1]],
            ['integer', ['0' => 1]],
            ['integer', [false => 1]],
            ['string', []],
            ['string', ['' => 1]],
            ['string', ['0.0' => 1]],
            ['string', ['string' => 1]],
            ['string', [null => 1]],
        ];
    }

    /**
     * @dataProvider validParameterKeyTypeProvider
     */
    public function testParameterKeyTypePass($type, $value)
    {
        Assert::parameterKeyType($type, $value, 'test');
        $this->addToAssertionCount(1);
    }

    public function invalidParameterKeyTypeProvider()
    {
        return [
            ['integer', [0, 'string' => 1]],
            ['integer', ['string' => 0, 1]],
            ['string', [0, 'string' => 1]],
            ['string', ['string' => 0, 1]],
        ];
    }

    /**
     * @dataProvider invalidParameterKeyTypeProvider
     * @covers \Realodix\Assert\ParameterKeyTypeException
     */
    public function testParameterKeyTypeFail($type, $value)
    {
        try {
            Assert::parameterKeyType($type, $value, 'test');
            $this->fail('Expected ParameterKeyTypeException');
        } catch (ParameterKeyTypeException $ex) {
            $this->assertSame($type, $ex->getType());
            $this->assertSame('test', $ex->getParameterName());
        }
    }

    /**
     * @covers \Realodix\Assert\ParameterAssertionException
     */
    public function testGivenUnsupportedTypeParameterKeyTypeFails()
    {
        $this->expectException(ParameterAssertionException::class);
        $this->expectExceptionMessage('Bad value for parameter type: must be "integer" or "string"');
        Assert::parameterKeyType('integer|string', [], 'test');
    }

    public function validParameterElementTypeProvider()
    {
        return [
            'empty'  => ['string', []],
            'simple' => ['string', ['hello', 'world']],
            'class'  => ['RuntimeException', [new RuntimeException]],
            'multi'  => ['string|array|Closure', [[], 'x', static function () {
            }]],
            'multiArray' => [['string', 'array', 'Closure'], [[], 'x', static function () {
            }]],
            'null' => ['integer|null', [null, 3, null]],
        ];
    }

    /**
     * @dataProvider validParameterElementTypeProvider
     */
    public function testParameterElementTypePass($type, $value)
    {
        Assert::parameterElementType($type, $value, 'test');
        $this->addToAssertionCount(1);
    }

    public function invalidParameterElementTypeProvider()
    {
        return [
            'simple' => ['string', ['hello', 5]],
            'class'  => ['RuntimeException', [new LogicException]],
            'multi'  => ['string|array|Closure', [[], static function () {
            }, 5]],
            'multiArray' => [['string', 'array', 'Closure'], [[], static function () {
            }, 5], 'string|array|Closure'],
            'null' => ['integer|string', [null, 3, null]],
        ];
    }

    /**
     * @dataProvider invalidParameterElementTypeProvider
     * @covers \Realodix\Assert\ParameterElementTypeException
     */
    public function testParameterElementTypeFail($type, $value, $typeInException = null)
    {
        try {
            Assert::parameterElementType($type, $value, 'test');
            $this->fail('Expected ParameterElementTypeException');
        } catch (ParameterElementTypeException $ex) {
            $this->assertSame($typeInException ?: $type, $ex->getElementType());
            $this->assertSame('test', $ex->getParameterName());
        }
    }

    /**
     * @covers \Realodix\Assert\ParameterTypeException
     */
    public function testParameterElementTypeBad()
    {
        $this->expectException(ParameterTypeException::class);
        Assert::parameterElementType('string', 'foo', 'test');
    }

    public function validNonEmptyStringProvider()
    {
        return [
            ['0'],
            ['0.0'],
            [' '],
            ["\n"],
            ['test'],
        ];
    }

    /**
     * @dataProvider validNonEmptyStringProvider
     */
    public function testNonEmptyStringPass($value)
    {
        Assert::nonEmptyString($value, 'test');
        $this->addToAssertionCount(1);
    }

    public function invalidNonEmptyStringProvider()
    {
        return [
            [null],
            [false],
            [0],
            [0.0],
            [''],
        ];
    }

    /**
     * @dataProvider invalidNonEmptyStringProvider
     * @covers \Realodix\Assert\ParameterTypeException
     */
    public function testNonEmptyStringFail($value)
    {
        $this->expectException(ParameterTypeException::class);
        $this->expectExceptionMessage('Bad value for parameter test: must be a non-empty string');
        Assert::nonEmptyString($value, 'test');
    }

    public function testInvariantPass()
    {
        Assert::invariant(true, 'test');
        $this->addToAssertionCount(1);
    }

    /**
     * @covers \Realodix\Assert\InvariantException
     */
    public function testInvariantFail()
    {
        $this->expectException(InvariantException::class);
        Assert::invariant(false, 'test');
    }

    /**
     * @covers \Realodix\Assert\UnreachableException
     */
    public function testUnreachableFail()
    {
        $this->expectException(UnreachableException::class);
        throw new UnreachableException('should always fail');
    }

    public function testPostconditionPass()
    {
        Assert::postcondition(true, 'test');
        $this->addToAssertionCount(1);
    }

    /**
     * @covers \Realodix\Assert\PostconditionException
     */
    public function testPostconditionFail()
    {
        $this->expectException(PostconditionException::class);
        Assert::postcondition(false, 'test');
    }

    public function provideInvalidExceptionArguments()
    {
        yield 'ParameterTypeException' => [
            ParameterTypeException::class,
            ['string', null],
            'Bad value for parameter parameterType: must be a string',
        ];
        yield 'ParameterAssertionException (parameterName)' => [
            ParameterAssertionException::class,
            [null, 'string'],
            'Bad value for parameter parameterName: must be a string',
        ];
        yield 'ParameterAssertionException (description)' => [
            ParameterAssertionException::class,
            ['string', null],
            'Bad value for parameter description: must be a string',
        ];
        yield 'ParameterElementTypeException' => [
            ParameterElementTypeException::class,
            ['string', null],
            'Bad value for parameter elementType: must be a string',
        ];
        yield 'ParameterKeyTypeException' => [
            ParameterKeyTypeException::class,
            ['string', null],
            'Bad value for parameter type: must be a string',
        ];
    }

    /**
     * @covers \Realodix\Assert\ParameterTypeException
     * @covers \Realodix\Assert\ParameterAssertionException
     * @covers \Realodix\Assert\ParameterElementTypeException
     * @covers \Realodix\Assert\ParameterKeyTypeException
     * @dataProvider provideInvalidExceptionArguments
     */
    public function testInvalidExceptionArguments($clazz, $args, $exceptionMsg)
    {
        // Testing that ParameterTypeException is thrown in the constructors
        // of the exceptions if not given strings
        $this->expectException(ParameterTypeException::class);
        $this->expectExceptionMessage($exceptionMsg);
        new $clazz(...$args);
    }
}
