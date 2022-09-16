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

Types         | Description
-------------- | ------------------------------------------------------------------
`array`        | Check that a key exists in an array
`bool`         | Check that a key does not exist in an array
`callable`     | Check that a value is a valid array key (int or string)
`countable`    | Check that an array contains a specific number of elements
`float`        | Check that an array contains at least a certain number of elements
`int`          | Check that an array contains at most a certain number of elements
`iterable`     | Check that an array has a count in the given range
`null`         | Check that an array is a non-associative list
`numeric`      | Check that an array is a non-associative list, and not empty
`object`       | Check that an array is associative and has strings as keys
`resource`     | Check that an array is associative and has strings as keys, and is not empty
`scalar`       | Check that an array is associative and has strings as keys, and is not empty
`string`       | Check that an array is associative and has strings as keys, and is not empty


## License

This package is licensed using the [MIT License](/LICENSE).
