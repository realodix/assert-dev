https://github.com/wikimedia/Assert

This package provides an alternative to PHP's `assert()` that allows for an simple and reliable way
to check preconditions and postconditions in PHP code.

All assertions in the [Assert](src/Assert.php) class throw an [`\InvalidArgumentException`][phpInvalidArgumentException] if they fail.

Usage
-------

The Assert class provides several static methods for checking various kinds of assertions. The most
common kind is to check the type of a parameter, typically in a constructor or a setter method:

```php
use Realodix\Assert\Assert;

public function setFoo($foo)
{
    Assert::type($foo, 'int', 'message');
}

public function setBar($foo)
{
    Assert::type($foo, 'int|float', 'message');
}
```

### Types Assertions

Types      | Description
---------- | ------------------------------------------------------------------
`scalar`   | Check that a value is a scalar
`string`   | Check that a value is a string
`non-empty-string` | Check that a value is a string, and not empty
`lowercase-string` | Check for lowercase character(s), see [`ctype_lower()`][phpCtypeLower]
`non-falsy-string` | Subtype of `non-empty-string`, but it excludes '0'
`bool`     | Check that a value is a boolean
`true`     | Check that a value is `true`
`false`    | Check that a value is `false`
`int`      | Check that a value is an integer
`positive-int` | Check that a value is a positive integer
`negative-int` | Check that a value is a negative integer
`float`    | Check that a value is a float
`numeric`  | Check that a value is numeric
`numeric-string` | `is_string($value) && is_numeric($value)`
`resource` | Check that a value is a resource
`object`   | Check that a value is an object
`callable` | Check that a value is a callable
`callable-string` | `is_string($value) && is_callable($value)`
`null`     | Check that a value is `null`

Types       | Description
----------- | ------------------------------------------------------------------
`array`     | Check that a value is an array
`non-empty-array` | Check that a value is an array, and not empty
`countable` | Check that the contents of a variable is a countable value
`iterable`  | Check that the contents of a variable is an iterable value
`list[]`    | Is an array that would pass an [`array_is_list()`][phpArrayIsList] check
`non-empty-list` | Is an array that would pass an [`array_is_list()`][phpArrayIsList] check, and not empty
`bool[]`    | `array<bool>`
`string[]`  | `array<string>`
`int[]`     | `array<int>`
`float[]`   | `array<float>`
`object[]`  | `array<object>`

#### Redundant types
You cannot declare a super type and (one/all) of its subtypes in the same union type declaration.

Super-type | Sub-type
---------- | -------------------------------------------------------------------
`scalar`   | `string`, `bool`, `numeric`, `int`, and  `float`
`string`   | `non-empty-string`, and `lowercase-string`
`non-empty-string` | `lowercase-string`
`numeric`  | `int`, `positive-int`, `negative-int`, and `float`
`int`      | `positive-int`, and `negative-int`
`bool`     | `true`, and  `false`
`array`    | `list[]`, `bool[]`, `string[]`, `int[]`, `float[]`, `object[]`, `float[]`, `non-empty-string`, `non-empty-array` , and `non-empty-list`
`non-empty-array` | `list[]` and `non-empty-list`
`list[]`   | `non-empty-list`

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


## License

This package is licensed using the [MIT License](/LICENSE).


[phpArrayIsList]: https://www.php.net/manual/en/function.array-is-list.php
[phpCtypeLower]: https://www.php.net/manual/en/function.ctype-lower.php
[phpInvalidArgumentException]: https://www.php.net/manual/en/class.invalidargumentexception.php
