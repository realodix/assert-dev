https://github.com/wikimedia/Assert

This package provides an alternative to PHP's `assert()` that allows for an simple and reliable way
to check preconditions and postconditions in PHP code.

All assertions in the [Assert](src/Assert.php) class throw an [`\InvalidArgumentException`](https://www.php.net/manual/en/class.invalidargumentexception.php) if they fail.

Usage
-------

The Assert class provides several static methods for checking various kinds of assertions. The most
common kind is to check the type of a parameter, typically in a constructor or a setter method:

```php
use Realodix\Assert\Assert;

public function setFoo($foo)
{
    Assert::type('integer', $foo, 'foo');
}

public function __construct($bar, array $bazz)
{
    Assert::type('Me\MyApp\SomeClass', $bar);
}
```

Checking parameters, or other assertions such as pre- or postconditions, is not recommended for
performance critical regions of the code, since evaluating expressions and calling the assertion
functions costs time.

### Types Assertions

Types       | Description
----------- | ------------------------------------------------------------------
`bool`      | Check whether a variable is a boolean or not
`int`       | Check whether a variable is of type integer or not
`float`     | Check whether a variable is of type float or not
`string`    | Check whether a variable is of type string or not
`non-empty-string` | Check whether a variable is of type string, and not empty
`numeric`   | Check whether a variable is a number or a numeric string, or not
`scalar`    | Check whether a variable is a scalar or not
`null`      | Check whether a variable is NULL or not
`resource`  | Check whether a variable is a resource or not
`object`    | Check whether a variable is an object or not
`callable`  | Check whether the contents of a variable can be called as a function or not

Types       | Description
----------- | ------------------------------------------------------------------
`array`     | Check whether a variable is an array or not
`countable` | Check whether the contents of a variable is a countable value or not
`iterable`  | Check whether the contents of a variable is an iterable value or not
`list[]`    | Check that an array is a non-associative list, see [php.net/manual/function.array-is-list](https://www.php.net/manual/en/function.array-is-list.php)
`bool[]`    | `array<mixed, bool>`
`string[]`  | `array<mixed, string>`
`int[]`     | `array<mixed, int>`
`float[]`   | `array<mixed, float>`
`object[]`  | `array<mixed, object>`
`non-empty-array` | Check whether a variable is of type array, and not empty
`non-empty-list`  | Check that an array is a non-associative list, and not empty

Super-type | Sub-type
---------- | ------------------------------------------------------------------
`scalar`   | `string`, `bool`, `numeric`, `int`, and  `float`
`bool`     | `true`, and  `false`
`numeric`  | `int`, and  `float`
`array`    | `list[]`, `bool[]`, `string[]`, `int[]`, `float[]`, `object[]`, `float[]`, `non-empty-string`, `non-empty-array` , and `non-empty-list`
`non-empty-array` | `non-empty-list`
`string`   | `non-empty-string`

## License

This package is licensed using the [MIT License](/LICENSE).
