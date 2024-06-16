- https://www.php.net/manual/en/language.types.intro.php
- https://github.com/beberlei/assert
- https://github.com/webmozarts/assert
- https://phpstan.org/writing-php-code/phpdoc-types
- https://phpstan.org/blog/phpstan-1-9-0-with-phpdoc-asserts-list-type

This package provides an alternative to PHP's `assert()` that allows for an simple and reliable way
to check preconditions and postconditions in PHP code.

Usage
-------

The Assert class provides several static methods for checking various kinds of assertions. The most
common kind is to check the type of a parameter, typically in a constructor or a setter method:

```php
use Realodix\Assert\Assert;
use Realodix\Assert\Type;

// Simple
Assert::type($foo, 'int');
Assert::type(new \stdClass, \stdClass::class);

// Union
Assert::type($foo, 'string|array');
Assert::type(new ClassA, [ClassA::class, ClassB::class]);

// Intersection
Type::intersection(new ClassAB, [ClassA::class, ClassB::class]);
```

All assertions in the [Assert](src/Assert.php) class throw an `\Realodix\Assert\Exception\TypeErrorException` if they fail.
You can pass an argument called `$message` to any assertion to control the exception message. Every exception contains a default
message and unique message code by default.

```php
use Realodix\Assert\Assert;

public function setFoo($foo)
{
    $message = 'foo';

    Assert::type($foo, 'int', $message);
}
```

### Types Assertions
Types      | Description
---------- | ------------------------------------------------------------------
`string`   | Check that a value is a string
`bool`     | Check that a value is a boolean
`true`     | Check that a value is `true`
`false`    | Check that a value is `false`
`int`      | Check that a value is an integer
`float`    | Check that a value is a float
`resource` | Check that a value is a resource
`object`   | Check that a value is an object
`callable` | Check that a value is a callable
`null`     | Check that a value is `null`

Types       | Description
----------- | ------------------------------------------------------------------
`array`     | Check that a value is an array
`countable` | Check that the contents of a variable is a countable value
`iterable`  | Check that the contents of a variable is an iterable value

#### Redundant types
You cannot declare a super type and (one/all) of its subtypes in the same union type declaration.

Super-type | Sub-type
---------- | -------------------------------------------------------------------
`bool`     | `true`, and  `false`

```php
use Realodix\Assert\Assert;

public function setFoo($foo)
{
    // Disallowed because false is a type of bool
    Assert::type($foo, 'bool|false');
}
```


### Array Assertions
Method                                            | Description
------------------------------------------------- | ------------------------------------------------------------------
`keyExists($array, $key, $message = '')`          | Check that a key exists in an array
`keyNotExists($array, $key, $message = '')`       | Check that a key does not exist in an array
`isMap($array, $message = '')`                    | Check that an array is associative and has strings as keys
`isNonEmptyMap($array, $message = '')`            | Check that an array is associative and has strings as keys, and is not empty
`count($array, $number, $message = '')`           | Check that an array contains a specific number of elements
`maxCount($array, $max, $message = '')`           | Check that an array contains at most a certain number of elements
`minCount($array, $min, $message = '')`           | Check that an array contains at least a certain number of elements
`countBetween($array, $min, $max, $message = '')` | Check that an array has a count in the given range
`validArrayKey($key, $message = '')`              | Check that a value is a valid array key (int or string)


## Static Analysis Support
Where applicable, assertion functions are annotated to support Psalm [Assertion syntax](https://psalm.dev/docs/annotating_code/assertion_syntax/).


## License
This package is licensed using the [MIT License](/LICENSE).


[phpEmpty]: https://www.php.net/manual/en/function.empty.php
