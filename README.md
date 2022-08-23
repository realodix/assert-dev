https://github.com/wikimedia/Assert

This package provides an alternative to PHP's `assert()` that allows for an simple and reliable way to check preconditions and postconditions in PHP code.

Usage
-------

The Assert class provides several static methods for checking various kinds of assertions.
The most common kind is to check the type of a parameter, typically in a constructor or a
setter method:

```php
function setFoo( $foo ) {
    Assert::isType( 'integer', $foo, 'foo' );
    Assert::parameter( $foo > 0, 'foo', 'must be greater than 0' );
}

function __construct( $bar, array $bazz ) {
    Assert::isType( 'Me\MyApp\SomeClass', $bar );
    Assert::parameterElementType( 'int', $bazz );
}
```

Checking parameters, or other assertions such as pre- or postconditions, is not recommended for performance critical regions of the code, since evaluating expressions and calling the assertion functions costs time.
